<?php

namespace App\Http\Services\Package;

use App\Http\Repositories\Package\PackageRepository;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Resources\Package\PackageResource;
use App\Models\Package\Package;
use Illuminate\Http\Request;

class PackageService
{
    public function __construct(
        protected PackageRepository $packageRepository,
    ) {}

    public function index(PaginationRequest $request)
    {
        $filters = $request->only(['name']);

        return customPaginate(
            new Package(),
            [
                'property_name' => 'data',
                'resource' => PackageResource::class,
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
            'package_category_id' => ['required', 'string', 'exists:package_categories,id'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required'],
            'discount' => ['nullable'],
        ]);

        return $this->packageRepository->create($validated);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'package_category_id' => ['required', 'string', 'exists:package_categories,id'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required'],
            'discount' => ['nullable'],
        ]);

        return $this->packageRepository->update($id, $validated);
    }

    public function destroy($id)
    {
        $this->packageRepository->delete($id);
    }
}
