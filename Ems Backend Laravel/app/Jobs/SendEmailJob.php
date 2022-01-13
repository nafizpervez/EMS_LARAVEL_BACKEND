<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $mail_to;
    protected $cc;
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mail_to, $cc, $email)
    {
        $this->mail_to = $mail_to;
        $this->cc = $cc;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->mail_to)
                ->cc($this->cc)
                ->queue($this->email);
    }
}
