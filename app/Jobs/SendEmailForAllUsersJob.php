<?php

namespace App\Jobs;

use App\Mail\SendEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailForAllUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $subject;
    private string $body;
    private ?string $attachment;

    /**
     * Create a new job instance.
     */
    public function __construct(string $subject,string $body,string $attachment=null)
    {
        //
        $this->subject = $subject;
        $this->body = $body;
        $this->attachment = $attachment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users=User::where('email','!=',null)->get();
       \Mail::to($users)->send(new SendEmail($this->subject,$this->body,$this->attachment));
    }
}
