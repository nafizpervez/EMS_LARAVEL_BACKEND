<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Http\Resources\UserShortInfoResource;
use App\Http\Resources\ApprovalRequestsResource;

class Conveyance extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'conveyance_type',
        'in_time',
        'out_time',
        'from',
        'to',
        'payable_amount',
        'details',
    ];

    public function approvalRequests()
    {
        $approval_requests = ApprovalRequest::where('approval_for', '=', 'conveyance')
                                ->where('related_id', '=', $this->id)
                                ->orderBy('line', 'DESC')->get();
        return ApprovalRequestsResource::collection($approval_requests);
    }

    public function applicant()
    {
        $applicant = User::find($this->applicant_id);
        return new UserShortInfoResource($applicant);
    }

    public function applicationStatus()
    {
        $coRe = ApprovalRequest::where('approval_for', '=', 'conveyance')
                                            ->where('related_id', '=', $this->id)
                                            ->where('need_approval_from', '=', '2010160')
                                            ->first();
        
        if(!$coRe){
            $coRe2 = ApprovalRequest::where('approval_for', '=', 'conveyance')
                                            ->where('related_id', '=', $this->id)
                                            ->where('need_approval_from', '=', '1010668')
                                            ->first();
            if (!$coRe2) {
                return 'pending';
            }else{
                return $coRe2->status;
            }
        }else{
            return $coRe->status;
        }
    }

    public function user()
    {
        return User::find($this->applicant_id);
    }

    public function approvers()
    {
        return ApprovalRequest::where('approval_for', '=', 'conveyance')
                                            ->where('related_id', '=', $this->id)
                                            ->orderBy('line', 'DESC')->get();
    }

    public function inTime()
    {
        return Carbon::parse($this->in_time)->format('g:i A');
    }

    public function outTime()
    {
        return Carbon::parse($this->out_time)->format('g:i A');
    }

    public function date()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y');
    }
}
