<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseRequisitionApprovalMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $purchase_requisition;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $purchase_requisition)
    {
        $this->user = $user;
        $this->purchase_requisition = $purchase_requisition;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.purchase_requisition_approval')
                    ->subject('Approved! Your Purchase Requisition has been Approved.')
                    ->with([
                        'user'=>$this->user,
                        'purchase_requisition'=>$this->purchase_requisition,
                        'approval'=>$this->approval
                    ]);
    }
}
