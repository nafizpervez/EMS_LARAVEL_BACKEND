<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Http\Resources\UserShortInfoResource;
use App\Http\Resources\AttachmentsResource;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'added_by',
        'product_category',
        'product_name',
        'product_particulars',
        'client_name',
        'per_unit_price',
        'latest_stock',
        'latest_stock_date',
        'physically_found_quantity',
        'sales_quantity',
        'purchase_quantity',
        'stock_quantity_to_be_reported',
        'excess_quantity',
        'shortage_quantity',
        'remarks',
    ];

    public function productImage()
    {
        $attachments = Attachments::where('related_to', '=', 'inventory')
                                    ->where('related_id', '=', $this->id)
                                    ->first();
        return new AttachmentsResource($attachments);
    }

    public function image()
    {
        return Attachments::where('related_to', '=', 'inventory')
                            ->where('related_id', '=', $this->id)
                            ->first();
    }

    public function addedBy()
    {
        $applicant = User::find($this->added_by);
        return new UserShortInfoResource($applicant);
    }

    public function user()
    {
        return User::find($this->added_by);
    }
}
