<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseRequisitionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' =>''.$this->id,
            'type' => 'PurchaseRequisition',
            'attributes' => [
                'applicant' => $this->applicant(),
                'application_date' => $this->created_at,
                'serial_id' => $this->serial_id,
                'expanse_type' => $this->expanse_type,
                'purpose_of_purchase' => $this->purpose_of_purchase,
                'user' => $this->user,
                'comment' => $this->comment,
                'status' => $this->applicationStatus(),
                'pr_items' => $this->prItems(),
                'approvals' => $this->approvalRequests(),                
                'attachments' => $this->attachments(), 
            ],
        ];
    }
}
