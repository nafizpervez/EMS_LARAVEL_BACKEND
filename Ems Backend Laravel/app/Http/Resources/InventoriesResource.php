<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoriesResource extends JsonResource
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
            'type' => 'Inventories',
            'attributes' => [
                'added_by' => $this->addedBy(),
                'product_category' => $this->product_category,
                'product_name' => $this->product_name,
                'product_image' => $this->productImage(),
                'product_particulars' => $this->product_particulars,
                'client_name' => $this->client_name,
                'per_unit_price' => $this->per_unit_price,
                'latest_stock' => $this->latest_stock,
                'latest_stock_date' => $this->latest_stock_date,
                'physically_found_quantity' => $this->physically_found_quantity,
                'sales_quantity' => $this->sales_quantity,
                'purchase_quantity' => $this->purchase_quantity,
                'stock_quantity_to_be_reported' => $this->stock_quantity_to_be_reported,
                'excess_quantity' => $this->excess_quantity,
                'shortage_quantity' => $this->shortage_quantity,
                'remarks' => $this->remarks,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
    }
}
