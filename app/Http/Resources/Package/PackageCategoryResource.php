<?php

namespace App\Http\Resources\Package;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageCategoryResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'packages' => $this->whenLoaded('packages', function () {
                return $this->packages->map(function ($package) {
                    return [
                        'id' => $package->id,
                        'name' => $package->name,
                    ];
                });
            }),
        ];
    }
}
