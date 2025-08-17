<?php

namespace App\Http\Services\Invoice;

use App\Http\Repositories\Invoice\InvoiceRepository;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Resources\Invoice\CustomerInvoiceResource;
use App\Models\Invoice\Invoice;
use Illuminate\Http\Request;

class InvoiceService
{
    public function __construct(
        protected InvoiceRepository $invoiceRepository,
    ) {}

    public function index(PaginationRequest $request)
    {
        $filters = $request->only(['name']);

        return customPaginate(
            new Invoice(),
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

    public function show(string $id)
    {
        return new CustomerInvoiceResource($this->invoiceRepository->findById($id, ['events']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_category_id' => ['required', 'string', 'exists:package_categories,id'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required'],
            'discount' => ['nullable'],
        ]);

        return $this->invoiceRepository->create($validated);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'package_category_id' => ['required', 'string', 'exists:package_categories,id'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required'],
            'discount' => ['nullable'],
        ]);

        return $this->invoiceRepository->update($id, $validated);
    }

    public function destroy($id)
    {
        $this->invoiceRepository->delete($id);
    }
}
