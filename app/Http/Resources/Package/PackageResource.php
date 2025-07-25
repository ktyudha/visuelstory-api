<?php

namespace App\Http\Resources\Package;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (int) $this->price,
            'discount' => $this->discount,
            'price_final' => $this->finalPrice,
            'package_category' => $this->package_category_id ?
                [
                    'id' => $this->packageCategory->id,
                    'name' => $this->packageCategory->name
                ]
                : null,
        ];
    }
}
