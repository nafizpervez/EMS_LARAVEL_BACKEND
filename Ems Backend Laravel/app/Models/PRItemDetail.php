<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PRItemDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_type',
        'item_description',
        'item_quantity',
        'measurement_of_unit',
        'required_date',
        'estimated_unit_price',
        'estimated_total_price',
        'purchase_requisition_id',
    ];
}
