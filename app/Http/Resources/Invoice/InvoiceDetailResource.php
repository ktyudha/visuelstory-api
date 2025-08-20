<?php

namespace App\Http\Resources\Invoice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceDetailResource extends JsonResource
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
            // 'invoice_id' => $this->invoice_id,
            'package' => $this->package_id ? [
                'id' => $this->package->id,
                'name' => $this->package->name,
                'description' => $this->package->description,
                'category' => $this->package->packageCategory->name,
            ] : null,
            'quantity' => (int) $this->quantity,
            'amount' => (int) $this->amount,
            'invoice_detail_addons' => InvoiceDetailAddOnResource::collection($this->invoiceDetailAddons),
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
        ];
    }
}
