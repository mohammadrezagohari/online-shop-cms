<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Kavenegar\Laravel\Message\KavenegarMessage;
use Kavenegar\LaravelNotification\KavenegarChannel;
//use Kavenegar\LaravelNotification\KavenegarMessage;

class SMSActivationCodeNotification extends Notification
{
    use Queueable;

    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function via($notifiable)
    {
        return [KavenegarChannel::class];
    }

    public function toKavenegar($notifiable)
    {
        $message = new KavenegarMessage();
        return $message->verifyLookup(env('KAVEHNEGAR_OTP_NAME'),[
            $this->code
        ])->to(Auth::user);
//        return new KavenegarMessage('کد تایید شما: '.$this->code)
//            ->from(config('services.kavenegar.from'))
//            ->to($notifiable->phone);
    }
}