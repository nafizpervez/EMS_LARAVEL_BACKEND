<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalendarEventsResource extends JsonResource
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
            'type' => 'CalendarEvents',
            'attributes' => [
                'created_by' => $this->createdBy(),
                'created_for' => $this->createdFor(),
                'title' => $this->title,
                'description' => $this->description,
                'event_date' => $this->eventDate(),
                'from' => $this->from,
                'to' => $this->to,
                'day_long_event' => $this->day_long_event,
                'event_type' => $this->event_type,
            ],
        ];
    }
}
