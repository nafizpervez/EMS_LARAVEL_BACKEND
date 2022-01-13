<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PRItemDetailsResource extends JsonResource
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
            'type' => 'PRItemDetail',
            'attributes' => [
                'purchase_type' => $this->purchase_type,
                'item_description' => $this->item_description,
                'item_quantity' => $this->item_quantity,
                'measurement_of_unit' => $this->measurement_of_unit,
                'required_date' => $this->required_date,
                'estimated_unit_price' => $this->estimated_unit_price,
                'estimated_total_price' => $this->estimated_total_price,
            ],
        ];
    }
}
