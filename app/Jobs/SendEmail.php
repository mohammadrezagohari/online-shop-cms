<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $subject;
    public string $body;
    public string $attachment;


    /**
     * Create a new job instance.
     */
    public function __construct(string $subject,string $body,string $attachment=null)
    {

        $this->subject = $subject;
        $this->body = $body;
        $this->attachment = $attachment;
    }

    /**
     * Execute the job.
     */
    public function handle(Mailer $mailer): void
    {
    $mailer->send(\App\Mail\SendEmail::class,[$this->subject,$this->body,$this->attachment]);
    }
}
