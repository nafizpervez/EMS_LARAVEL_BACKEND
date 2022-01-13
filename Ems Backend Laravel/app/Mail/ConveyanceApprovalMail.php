<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConveyanceApprovalMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $conveyance;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $conveyance)
    {
        $this->user = $user;
        $this->conveyance = $conveyance;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.conveyance_approval')
                    ->subject('Approved! Your Conveyance Application has been Approved.')
                    ->with([
                        'user'=>$this->user,
                        'conveyance'=>$this->conveyance,
                    ]);
    }
}
