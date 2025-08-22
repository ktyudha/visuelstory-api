<?php

namespace App\Http\Resources\Invoice;

use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Invoice\InvoiceDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerInvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'customer' => $this->customer_id ? new CustomerResource($this->customer) : null,
            'invoice_number' => $this->invoice_number,
            'invoice_url' => $this->invoice_url,
            'transaction_status' => $this->transaction_status,
            'total_price' => (int) $this->total_price,
            'proof' => $this->proofUrl,
            'invoice_details' => InvoiceDetailResource::collection($this->invoiceDetails),
            'created_at' => $this->created_at
            // 'invoice_detail_addon' => $this->invoice_detail_addon,
        ];
    }
}
