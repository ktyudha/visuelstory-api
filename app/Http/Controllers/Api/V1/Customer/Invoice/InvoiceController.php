<?php

namespace App\Http\Controllers\Api\V1\Customer\Invoice;

use App\Http\Requests\Invoice\CustomerInvoiceRequest;
use App\Http\Services\Invoice\CustomerInvoiceService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Invoice\CustomerInvoiceResource;

class InvoiceController extends Controller
{
    public function __construct(protected CustomerInvoiceService $customerInvoiceService) {}

    public function store(CustomerInvoiceRequest $request)
    {
        $data = $this->customerInvoiceService->store($request);

        return response()->json([
            'status' => 'success',
            'data' => new CustomerInvoiceResource($data),
        ]);
    }
}
