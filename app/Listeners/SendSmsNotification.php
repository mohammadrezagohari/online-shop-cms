<?php

namespace App\Listeners;

use App\Events\SendSms;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Kavenegar;


class SendSmsNotification implements ShouldQueue
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
    public function handle(SendSms $event):void
    {
        $receptor=User::where('mobile','!=',null)->pluck('mobile');
        $type = env("KAVEHNEGAR_DATA_TYPE_PASS");
        $template = env("KAVEHNEGAR_OTP_NAME");
        Kavenegar::VerifyLookup($receptor,$event->body, null, null, $template, $type);

    }
}
