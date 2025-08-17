<?php

namespace App\Http\Resources\Invoice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceDetailAddOnResource extends JsonResource
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
            // 'invoice_detail_id' => $this->invoice_detail_id,
            'package_addon' => $this->package_addon_id ? [
                'id' => $this->packageAddOn->id,
                'name' => $this->packageAddOn->name,
                'price' => (int) $this->packageAddOn->price
            ] : null,
            'quantity' => (int) $this->quantity,
            'amount' => (int) $this->amount,
        ];
    }
}
