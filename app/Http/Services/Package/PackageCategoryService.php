<?php

namespace App\Http\Services\Package;

use App\Http\Repositories\Package\PackageCategoryRepository;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Resources\Package\PackageCategoryResource;
use App\Models\Package\PackageCategory;
use Illuminate\Http\Request;

class PackageCategoryService
{
    public function __construct(
        protected PackageCategoryRepository $packageCategoryRepository,
    ) {}

    public function index(PaginationRequest $request)
    {
        $filters = $request->only(['name']);

        return customPaginate(
            new PackageCategory(),
            [
                'property_name' => 'data',
                'resource' => PackageCategoryResource::class,
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
            'description' => ['required', 'string'],
        ]);

        return $this->packageCategoryRepository->create($validated);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        return $this->packageCategoryRepository->update($id, $validated);
    }

    public function destroy($id)
    {
        $this->packageCategoryRepository->delete($id);
    }
}
