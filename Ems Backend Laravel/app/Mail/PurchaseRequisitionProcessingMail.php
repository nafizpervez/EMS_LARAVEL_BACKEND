<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseRequisitionProcessingMail extends Mailable
{
    use Queueable, SerializesModels;
    public $purchase_requisition;
    public $approval;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($purchase_requisition, $approval)
    {
        $this->purchase_requisition = $purchase_requisition;
        $this->approval = $approval;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.purchase_requisition_processing')
                    ->subject('Application Processing! Purchase Requisition Application is being Processed.')
                    ->with([
                        'purchase_requisition'=>$this->purchase_requisition,
                        'approval'=>$this->approval
                    ]);
    }
}
