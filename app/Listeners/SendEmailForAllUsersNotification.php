<?php

namespace App\Listeners;

use App\Events\SendEmailForAllUsersEvent;
use App\Mail\SendEmail;
use App\Models\User;
use http\Env\Response;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\JsonResponse;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailForAllUsersNotification implements  ShouldQueue
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
    public function handle(SendEmailForAllUsersEvent $event)
    {


        $users=User::where('email','!=',null)->first();
        if($event->attachment){
            \Mail::to($users)->send(new SendEmail($event->subject,$event->body,$event->attachment));

        }else{
            \Mail::to($users)->send(new SendEmail($event->subject,$event->body));


        }
    }
}
