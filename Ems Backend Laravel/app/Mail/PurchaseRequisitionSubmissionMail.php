<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseRequisitionSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $purchase_requisition;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($purchase_requisition)
    {
        $this->purchase_requisition = $purchase_requisition;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.purchase_requisition_submission')
                    ->subject('Submission Confirmation! Purchase Requisition Application has been Submitted.')
                    ->with([
                        'purchase_requisition'=>$this->purchase_requisition,
                    ]);
    }
}
