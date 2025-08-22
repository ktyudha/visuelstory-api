<?php

namespace App\Http\Resources\Event;

use App\Http\Resources\Invoice\InvoiceDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'customer' => $this->invoice->customer ? [
                'id' => $this->invoice->customer->id,
                'name' => $this->invoice->customer->name,
            ] : null,
            'invoice' => $this->invoice ? [
                'id' => $this->invoice->id,
                'number' => $this->invoice->invoice_number,
            ] : null,
            'invoice_detail' => new InvoiceDetailResource($this->whenLoaded('invoiceDetail')),
            'note' => $this->note,
            'date' => $this->date,
            'location' => $this->location,
        ];
    }
}
