<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllotedLeaveResource extends JsonResource
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
            'type' => 'AllotedLeave',
            'attributes' => [
                'total_alloted_leaves' => $this->total_alloted_leaves,
                'sick_leave' => $this->sick_leave,
                'annual_leave' => $this->annual_leave,
                'maternity_leave' => $this->maternity_leave,
                'unpaid_leave' => $this->unpaid_leave,
                'enjoyed_total_leave_count' => $this->enjoyedTotalLeaveCount(),
                'remaining_leave_count' => $this->remainingLeaveCount(),
                'business_year_start' => $this->business_year_start,
                'business_year_end' => $this->business_year_end,
            ],
        ];
    }
}
