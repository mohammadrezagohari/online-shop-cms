<?php

namespace App\Listeners;

use App\Events\SendEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailNotification implements ShouldQueue
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
    public function handle(SendEmail $event): void
    {
       $users=User::where('email','!=',null)->get();
       \Mail::to($users)->send(new \App\Mail\SendEmail($event->subject,$event->body,$event->attachment));
    }
}
