<?php

namespace App\Listeners\Auth;

use App\Mail\Auth\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOtpMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // Mail::to($event->data['email'])->send(new OtpMail($event->data));
        Mail::to($event->data['email'])->queue(new OtpMail($event->data));
    }
}
