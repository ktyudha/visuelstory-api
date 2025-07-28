<?php

namespace App\Http\Services\Event;

use App\Http\Repositories\Event\EventRepository;
use Illuminate\Http\Request;

class EventService
{
    public function __construct(
        protected EventRepository $eventRepository,
    ) {}

    public function index()
    {
        return $this->eventRepository->findAll();
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
