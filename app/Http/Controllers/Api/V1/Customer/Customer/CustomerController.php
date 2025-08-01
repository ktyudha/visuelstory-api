<?php

namespace App\Http\Controllers\Api\V1\Customer\Customer;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerRequest;
use App\Http\Services\Customer\CustomerService;

class CustomerController extends Controller
{
    public function __construct(protected CustomerService $customerService) {}

    public function firstOrCreate(CustomerRequest $request)
    {
        $data = $this->customerService->firstOrCreate($request);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
