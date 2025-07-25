<?php

namespace App\Http\Services\Package;

use App\Http\Repositories\Package\PackageCategoryRepository;
use Illuminate\Http\Request;

class PackageCategoryService
{
    public function __construct(
        protected PackageCategoryRepository $packageCategoryRepository,
    ) {}

    public function index()
    {
        return $this->packageCategoryRepository->findAll();
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
