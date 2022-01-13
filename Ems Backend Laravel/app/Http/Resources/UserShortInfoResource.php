<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserShortInfoResource extends JsonResource
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
                'designation' => $this->designation,
                'division' => $this->division,
                'department' => $this->department,
                'grade' => $this->grade,
            ],
        ];
    }
}
