<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kavenegar;

class SendSmsForAllUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $body;

    /**
     * Create a new job instance.
     */
    public function __construct( string $body)
    {
        $this->body = $body;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $receptor=User::where('mobile','!=',null)->pluck('mobile');

        $type = env("KAVEHNEGAR_DATA_TYPE_PASS");
        $template = env("KAVEHNEGAR_OTP_NAME");
        Kavenegar::VerifyLookup($receptor, $this->body, null, null, $template, $type);


    }
}
