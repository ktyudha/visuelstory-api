<?php

namespace App\Http\Controllers\Api\V1\User\Package;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\Package\PackageAddOnService;

class PackageAddOnController extends Controller
{
    public function __construct(protected PackageAddOnService $packageAddOnService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->packageAddOnService->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->packageAddOnService->store($request);

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
        $data = $this->packageAddOnService->update($id, $request);

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
        $this->packageAddOnService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
