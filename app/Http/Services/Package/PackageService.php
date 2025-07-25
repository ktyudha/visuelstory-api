<?php

namespace App\Http\Services\Package;

use App\Http\Repositories\Package\PackageRepository;
use Illuminate\Http\Request;

class PackageService
{
    public function __construct(
        protected PackageRepository $packageRepository,
    ) {}

    public function index()
    {
        return $this->packageRepository->findAll();
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
