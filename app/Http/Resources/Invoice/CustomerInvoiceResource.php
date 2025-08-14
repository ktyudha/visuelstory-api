<?php

namespace App\Http\Resources\Invoice;

use App\Http\Resources\Event\EventResource;
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
            'customer' => $this->customer_id ? [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
            ] : null,
            'invoice_number' => $this->invoice_number,
            'invoice_url' => $this->invoice_url,
            'total_price' => $this->total_price,
            'proof' => $this->proofUrl,
            'events' => $this->whenLoaded('events', function () {
                return $this->events->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'note' => $event->note,
                        'date' => $event->date,
                        'location' => $event->location,
                    ];
                });
            }),
            'invoice_detail' => InvoiceDetailResource::collection($this->invoiceDetails),
            // 'invoice_detail_addon' => $this->invoice_detail_addon,
        ];
    }
}
