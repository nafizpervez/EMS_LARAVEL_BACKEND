<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConveyancesResource extends JsonResource
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
            'type' => 'Conveyances',
            'attributes' => [
                'applicant' => $this->applicant(),
                'application_date' => $this->created_at,
                'conveyance_type' => $this->conveyance_type,
                'in_time' => $this->in_time,
                'out_time' => $this->out_time,
                'from' => $this->from,
                'to' => $this->to,
                'payable_amount' => (int)$this->payable_amount,
                'details' => $this->details,
                'approvals' => $this->approvalRequests(),
                'status' => $this->applicationStatus(),
            ],
        ];
    }
}
