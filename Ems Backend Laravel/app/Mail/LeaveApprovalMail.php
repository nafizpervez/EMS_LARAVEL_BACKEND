<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveApprovalMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $leave;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $leave)
    {
        $this->user = $user;
        $this->leave = $leave;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.leave_approval')
                    ->subject('Approved! Your Leave Application has been Approved.')
                    ->with([
                        'user'=>$this->user,
                        'leave'=>$this->leave,
                    ]);
    }
}
