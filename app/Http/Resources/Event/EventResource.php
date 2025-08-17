<?php

namespace App\Http\Resources\Event;

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
            'customer' => $this->customer ? [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
            ] : null,
            'package' => $this->package_id ? [
                'id' => $this->package->id,
                'name' => $this->package->name,
            ] : null,
            'invoice' => $this->invoice_id ? [
                'id' => $this->invoice->id,
                'number' => $this->invoice->invoice_number,
            ] : null,
            'note' => $this->note,
            'date' => $this->date,
            'location' => $this->location,
        ];
    }
}
