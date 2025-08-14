<?php

namespace App\Http\Controllers\Api\V1\User\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Services\Invoice\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(protected InvoiceService $invoiceService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(PaginationRequest $request)
    {
        return $this->invoiceService->index($request);
    }

    public function show($id)
    {
        return $this->invoiceService->show($id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->invoiceService->store($request);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $this->invoiceService->update($id, $request);

        return response()->json([
            'message' => 'success',
            'data' =>  $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->invoiceService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
