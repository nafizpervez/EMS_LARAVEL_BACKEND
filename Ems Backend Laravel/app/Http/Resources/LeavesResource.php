<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeavesResource extends JsonResource
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
            'type' => 'Leaves',
            'attributes' => [
                'applicant' => $this->applicant(),
                'application_date' => $this->created_at,
                'leave_type' => $this->leave_type,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'total_days' => $this->total_days,
                'details' => $this->details,
                'emergency_contact_person' => $this->emergency_contact_person,
                'emergency_contact_number' => $this->emergency_contact_number,
                'emergency_contact_address' => $this->emergency_contact_address,
                'approvals' => $this->approvalRequests(),
                'status' => $this->applicationStatus(),
                'attachments' => $this->attachments(),                
            ],
        ];
    }
}
