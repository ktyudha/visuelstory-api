<?php

namespace App\Http\Controllers\Api\V1\User\Package;

use App\Http\Services\Package\PackageCategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;

class PackageCategoryController extends Controller
{
    public function __construct(protected PackageCategoryService $packageCategoryService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(PaginationRequest $request)
    {
        return $this->packageCategoryService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->packageCategoryService->store($request);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $this->packageCategoryService->update($id, $request);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->packageCategoryService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
