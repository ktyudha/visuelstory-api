<?php

namespace App\Http\Services\Invoice;

use App\Http\Repositories\Invoice\InvoiceRepository;
use Illuminate\Http\Request;

class CustomerService
{
    public function __construct(
        protected InvoiceRepository $invoiceRepository,
    ) {}

    public function index()
    {
        return $this->invoiceRepository->findAll();
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
