<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

use App\Models\Role;

class UsersResource extends JsonResource
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
            'type' => 'Users',
            'attributes' => [
                'name' => $this->name,
                'employee_id' => $this->employee_id,
                'contact_number' => $this->contact_number,
                'email' => $this->email,
                'designation' => $this->designation,
                'grade' => $this->grade,
                'division' => $this->division,
                'department' => $this->department,
                'unit' => $this->unit,
                'sub_unit' => $this->sub_unit,
                'date_of_joining' => $this->date_of_joining,
                'location' => $this->location,
                'blood_group' => $this->blood_group,
                'avater' => $this->avater,
                'active' => $this->active,
                'alloted_leaves' => $this->allotedLeave(),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
    }
}
