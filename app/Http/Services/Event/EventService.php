<?php

namespace App\Http\Services\Event;

use App\Http\Repositories\Event\EventRepository;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Resources\Event\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventService
{
    public function __construct(
        protected EventRepository $eventRepository,
    ) {}

    public function index(PaginationRequest $request)
    {
        $filters = $request->only(['name']);

        return customPaginate(
            new Event(),
            [
                'property_name' => 'data',
                'resource' => EventResource::class,
                'sort_by_property' => 'created_at',
                'order_direction' => 'desc',
                // 'sort_by' => 'oldest',
                // 'relations' => ['invoiceDetails'],
            ],
            $request->limit ?? 10,
            $filters
        );
    }

    public function show(string $id)
    {
        return new EventResource($this->eventRepository->findById($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'note' => ['required', 'string'],
            'date' => ['required'],
            'location' => ['required', 'string'],
            'pacakge_id' => ['required', 'exists:packages,id'],
            'invoice_id' => ['required', 'exists:invoices,id'],
        ]);

        return $this->eventRepository->create($validated);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'note' => ['required', 'string'],
            'date' => ['required'],
            'location' => ['required', 'string'],
            'pacakge_id' => ['required', 'exists:packages,id'],
            'invoice_id' => ['required', 'exists:invoices,id'],
        ]);

        return $this->eventRepository->update($id, $validated);
    }

    public function destroy($id)
    {
        $this->eventRepository->delete($id);
    }
}
