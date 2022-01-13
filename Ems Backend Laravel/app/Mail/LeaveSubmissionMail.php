<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $leave;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $leave)
    {
        $this->leave = $leave;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.leave_submission')
                    ->subject('Submission Confirmation! Leave Application has been Submitted.')
                    ->with([
                        'leave'=>$this->leave,
                    ]);
    }
}
