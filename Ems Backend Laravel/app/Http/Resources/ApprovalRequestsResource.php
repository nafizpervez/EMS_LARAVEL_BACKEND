<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalRequestsResource extends JsonResource
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
            'type' => 'ApprovalRequest',
            'attributes' => [
                'need_approval_from' => $this->approvalFrom(),
                'status' => $this->status,
                'line' => $this->line,
                'remark' => $this->remark,
                'can_approve' => $this->canApprov(),
            ],
        ];
    }
}
