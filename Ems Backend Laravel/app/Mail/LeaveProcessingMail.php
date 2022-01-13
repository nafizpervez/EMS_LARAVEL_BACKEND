<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveProcessingMail extends Mailable
{
    use Queueable, SerializesModels;
    public $leave;
    public $approval;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($leave, $approval)
    {
        $this->leave = $leave;
        $this->approval = $approval;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.leave_processing')
                    ->subject('Application Processing! Leave Application is being Processed.')
                    ->with([
                        'leave'=>$this->leave,
                        'approval'=>$this->approval
                    ]);
    }
}
