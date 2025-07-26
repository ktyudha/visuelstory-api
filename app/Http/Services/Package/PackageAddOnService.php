<?php

namespace App\Http\Services\Package;

use App\Http\Repositories\Package\PackageAddOnRepository;
use Illuminate\Http\Request;

class PackageAddOnService
{
    public function __construct(
        protected PackageAddOnRepository $packageAddOnRepository,
    ) {}

    public function index()
    {
        return $this->packageAddOnRepository->findAll();
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
