<?php

namespace App\Http\Services\Invoice;

use App\Http\Repositories\Invoice\InvoiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerInvoiceService
{
    public function __construct(
        protected InvoiceRepository $invoiceRepository,
    ) {}

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $validated = $request->validated();
        });

        // $validated = $request->validate([
        //     'package_category_id' => ['required', 'string', 'exists:package_categories,id'],
        //     'name' => ['required', 'string'],
        //     'description' => ['required', 'string'],
        //     'price' => ['required'],
        //     'discount' => ['nullable'],
        // ]);

        // return $this->invoiceRepository->create($validated);
    }
}
