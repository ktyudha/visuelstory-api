<?php

namespace App\Http\Services\Invoice;

use App\Enums\Guard\GuardEnum;
use App\Http\Repositories\Customer\CustomerRepository;
use App\Http\Repositories\Event\EventRepository;
use App\Http\Repositories\Invoice\InvoiceDetailAddOnRepository;
use App\Http\Repositories\Invoice\InvoiceDetailRepository;
use App\Http\Repositories\Invoice\InvoiceRepository;
use App\Http\Repositories\Package\PackageAddOnRepository;
use App\Http\Repositories\Package\PackageRepository;
use App\Http\Requests\Invoice\CustomerInvoiceRequest;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Resources\Invoice\CustomerInvoiceResource;
use App\Http\Services\FileManager\FileManagerService;
use App\Models\Invoice\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerInvoiceService
{
    protected $customer;

    public function __construct(
        protected CustomerRepository $customerRepository,
        protected PackageRepository $packageRepository,
        protected PackageAddOnRepository $packageAddOnRepository,
        protected InvoiceRepository $invoiceRepository,
        protected InvoiceDetailRepository $invoiceDetailRepository,
        protected InvoiceDetailAddOnRepository $invoiceDetailAddOnRepository,
        protected EventRepository $eventRepository,
        protected FileManagerService $fileManagerService
    ) {
        $this->customer = auth()->guard(GuardEnum::CUSTOMER)->user();
    }

    public function index(PaginationRequest $request)
    {
        $filters = $request->only(['name']);
        $model = (new Invoice())->where('customer_id', $this->customer->id);

        return customPaginate(
            $model,
            [
                'property_name' => 'data',
                'resource' => CustomerInvoiceResource::class,
                'sort_by_property' => 'created_at',
                'order_direction' => 'desc',
                // 'sort_by' => 'oldest',
                'relations' => ['events'],
            ],
            $request->limit ?? 10,
            $filters
        );
    }

    public function store(CustomerInvoiceRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $validated = $request->validated();

            // $customerId = $this->customerRepository->findById($validated['customer_id']);

            $packageIds = collect($validated['packages'])->pluck('id');
            $packages = $this->packageRepository->findMany($packageIds);

            $itemPackages = collect($packages)->map(function ($package, $key) use ($validated) {
                $qty =  (int) $validated['packages'][$key]['quantity'];
                return [
                    'package_id'       => $package->id,
                    'amount'    => (int) $package->final_price * $qty,
                    'quantity' => $qty,
                ];
            });

            $price = $itemPackages->sum(fn($item) => $item['amount'] * $item['quantity']);
            $itemPackageAddOns = collect();

            foreach ($validated['packages'] as $package) {
                if (isset($package['package_addons'])) {
                    foreach ($package['package_addons'] as $addon) {
                        $packageAddOn = $this->packageAddOnRepository->findById($addon['id']);
                        $itemPackageAddOns->push([
                            'package_id'       => $package['id'],
                            'package_addon_id' => $addon['id'],
                            'quantity' => (int) $addon['quantity'],
                            'amount' => (int) $packageAddOn->price * $addon['quantity'],
                        ]);
                    }
                }
            }
            $pricePackageAddOns = $itemPackageAddOns->sum('amount');
            $price += $pricePackageAddOns;

            $payload['customer_id'] = $validated['customer_id'];
            $payload['total_price'] = $price;
            $payload['invoice_number'] = generateInvoiceNumber();

            if ($request->file('proof')) {
                $payload['proof'] = $request->proof->store(
                    $this->fileManagerService->getUserPath('invoices/proof'),
                    $this->fileManagerService->getDisk()
                );
            }

            // Invoice
            $invoice = $this->invoiceRepository->create($payload);

            // Event 
            foreach ($validated['packages'] as $pckg) {
                $this->eventRepository->create([
                    'invoice_id' => $invoice->id,
                    'package_id' => $pckg['id'],
                    'note' => $pckg['note'] ?? '-',
                    'date' => $pckg['date'] ?? '-',
                    'location' => $pckg['location'] ?? '-',
                ]);
            }

            $invoiceDetailMap = [];
            foreach ($itemPackages as $itemPackage) {
                // Invoice Detail
                $invoiceDetail = $this->invoiceDetailRepository->create([
                    'invoice_id' => $invoice->id,
                    'package_id' => $itemPackage['package_id'],
                    'amount' => $itemPackage['amount'],
                    'quantity' => $itemPackage['quantity'],
                ]);

                $invoiceDetailMap[$itemPackage['package_id']] = $invoiceDetail->id;
            }

            $itemPackageAddOns->each(function ($item) use ($invoiceDetailMap) {
                $invoiceDetailId = $invoiceDetailMap[$item['package_id']];
                if ($invoiceDetailId) {
                    $this->invoiceDetailAddOnRepository->create([
                        'invoice_detail_id' => $invoiceDetailId,
                        'package_addon_id'  => $item['package_addon_id'],
                        'amount'            => $item['amount'],
                        'quantity'          => $item['quantity'],
                    ]);
                }
            });



            return $invoice;
        });
    }
}
