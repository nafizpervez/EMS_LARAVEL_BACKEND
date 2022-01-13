<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Http\Resources\UserShortInfoResource;

class ApprovalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'need_approval_from',
        'approval_for',
        'status',
        'line',
        'related_id',
        'remark',
    ];

    public function approvalFrom()
    {
        $approvee = User::where('employee_id', '=', $this->need_approval_from)->first();
        return new UserShortInfoResource($approvee);
    }

    public function canApprov()
    {
        return true;
    }

    public function approvee()
    {
        return User::where('employee_id', '=', $this->need_approval_from)->first();        
    }

    public function relatedTo()
    {
        if ($this->approval_for == 'pr') {
            return PurchaseRequisition::find($this->related_id);
        }
        else if ($this->approval_for == 'leave') {
            return Leave::find($this->related_id);
        } 
        else {
            return Conveyance::find($this->related_id);
        }  
    }
}
