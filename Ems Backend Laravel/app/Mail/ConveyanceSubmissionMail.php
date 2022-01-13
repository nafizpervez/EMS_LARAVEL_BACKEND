<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConveyanceSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $conveyance;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conveyance)
    {
        $this->conveyance = $conveyance;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.conveyance_submission')
                    ->subject('Submission Confirmation! Conveyance Application has been Submitted.')
                    ->with([
                        'conveyance'=>$this->conveyance,
                    ]);
    }
}
