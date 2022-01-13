<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentsResource extends JsonResource
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
            'type' => 'Attachment',
            'attributes' => [
                'attachment_type' => $this->attachment_type,
                'attachment_url' => $this->attachment_url,
            ],
        ];
    }
}
