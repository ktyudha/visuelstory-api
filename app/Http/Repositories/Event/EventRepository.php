<?php

namespace App\Http\Repositories\Event;

use App\Http\Repositories\BaseRepository;
use App\Models\Event;

class EventRepository extends BaseRepository
{
    public function __construct(protected Event $event)
    {
        parent::__construct($event);
    }
}
