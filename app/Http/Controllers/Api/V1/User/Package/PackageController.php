<?php

namespace App\Http\Controllers\Api\V1\User\Package;

use App\Http\Services\Package\PackageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Resources\Package\PackageResource;

class PackageController extends Controller
{
    public function __construct(protected PackageService $packageService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(PaginationRequest $request)
    {
        return $this->packageService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->packageService->store($request);

        return response()->json([
            'message' => 'success',
            'data' => new PackageResource($data)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $this->packageService->update($id, $request);

        return response()->json([
            'message' => 'success',
            'data' =>  new PackageResource($data)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->packageService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
