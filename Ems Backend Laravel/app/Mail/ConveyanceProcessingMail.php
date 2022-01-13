<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConveyanceProcessingMail extends Mailable
{
    use Queueable, SerializesModels;
    public $conveyance;
    public $approval;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $conveyance, $approval)
    {
        $this->conveyance = $conveyance;
        $this->approval = $approval;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.conveyance_processing')
                    ->subject('Application Processing! Conveyance Application is being Processed.')
                    ->with([
                        'conveyance'=>$this->conveyance,
                        'approval'=>$this->approval
                    ]);
    }
}
