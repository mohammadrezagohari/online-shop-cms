<?php

namespace App\Console\Commands;

use App\Events\SendEmail;
use App\Models\Market\Email;
use App\Models\Market\EmailFile;
use Illuminate\Console\Command;

class AutoSendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:sendEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for send email ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emailsForSend = Email::where('published_at', '=', now())->get();

        foreach ($emailsForSend as $emailForSend) {
            $attachment = EmailFile::where('public_mail_id', '=', $emailForSend['id'])->first()->toArray();

            event(new SendEmail($emailForSend['subject'], $emailForSend['body'], $attachment['file_path']));

        }
    }
}
