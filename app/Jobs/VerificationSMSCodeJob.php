<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kavenegar;
use Illuminate\Support\Facades\Log;

class VerificationSMSCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $code;
    private $user;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($code,$user)
    {
        $this->code = $code;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user =$this->user;
        $receptor = $user->mobile;
        $activationCode = $this->code;
        $type = env("KAVEHNEGAR_DATA_TYPE_PASS");
        $template = env("KAVEHNEGAR_OTP_NAME");
        Kavenegar::VerifyLookup($receptor, $activationCode, null, null, $template, $type);
        Log::info($user->created_at,
            [
                'User Generate Mobile Number' => $user->mobile,
                'Activation Code User' => $this->code,
            ]
        );
    }
}