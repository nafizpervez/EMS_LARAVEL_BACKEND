<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleForcastsResource extends JsonResource
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
            'type' => 'SaleForcasts',
            'attributes' => [
                'name_of_the_account' => $this->name_of_the_account,
                'account_manager_name' => $this->account_manager_name,
                'contact_person' => $this->contact_person,
                'project_name' => $this->project_name,
                'contact_person_mobile' => $this->contact_person_mobile,
                'contact_person_email' => $this->contact_person_email,
                'value_of_the_project' => $this->value_of_the_project,
                'po_date' => $this->po_date,
                'proposal_submission_date' => $this->proposal_submission_date,
                'last_follow_up_date' => $this->last_follow_up_date,
                'expected_closing_date' => $this->expected_closing_date,
                'probability_of_closing' => $this->probability_of_closing,
                'activity_update' => $this->activity_update,
                'remarks' => $this->remarks,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
    }
}
