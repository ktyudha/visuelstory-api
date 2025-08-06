<?php

namespace App\Http\Services\Package;

use App\Http\Repositories\Package\PackageAddOnRepository;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Resources\Package\PackageAddOnResource;
use App\Models\Package\PackageAddOn;
use Illuminate\Http\Request;

class PackageAddOnService
{
    public function __construct(
        protected PackageAddOnRepository $packageAddOnRepository,
    ) {}

    public function index(PaginationRequest $request)
    {
        $filters = $request->only(['name']);

        return customPaginate(
            new PackageAddOn(),
            [
                'property_name' => 'data',
                'resource' => PackageAddOnResource::class,
                'sort_by_property' => 'created_at',
                'order_direction' => 'desc',
                // 'sort_by' => 'oldest',
                // 'relations' => ['invoiceDetails'],
            ],
            $request->limit ?? 10,
            $filters
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required'],
        ]);

        return $this->packageAddOnRepository->create($validated);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required'],
        ]);

        return $this->packageAddOnRepository->update($id, $validated);
    }

    public function destroy($id)
    {
        $this->packageAddOnRepository->delete($id);
    }
}
