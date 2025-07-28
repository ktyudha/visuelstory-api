<?php

namespace App\Http\Controllers\Api\V1\User\Event;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\Event\EventService;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class EventController extends Controller
{
    public function __construct(protected EventService $eventService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->eventService->index();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->eventService->store($request);

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
        $data = $this->eventService->update($id, $request);

        return response()->json([
            'message' => 'success',
            'data' =>  $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->eventService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
