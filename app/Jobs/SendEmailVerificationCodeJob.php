<?php

namespace App\Jobs;

use App\Mail\sendEmailVerificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailVerificationCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $code;

    /**
     * Create a new job instance.
     */
    public function __construct($user,$code)
    {
        //
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Mail::to($this->user)->send(new sendEmailVerificationMail($this->user,$this->code));
    }
}
