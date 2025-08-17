<?php

namespace App\Http\Controllers\Api\V1\Customer\Event;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Event\EventRequest;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Services\Event\CustomerEventService;

class EventController extends Controller
{
    public function __construct(protected CustomerEventService $customerEventService) {}

    public function index(PaginationRequest $request)
    {
        return $this->customerEventService->index($request);
    }

    public function store(EventRequest $request)
    {
        $data = $this->customerEventService->store($request);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
