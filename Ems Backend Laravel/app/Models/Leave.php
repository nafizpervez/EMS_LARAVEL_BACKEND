<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\ApprovalRequestsResource;

use App\Http\Resources\UserShortInfoResource;
use App\Http\Resources\AttachmentsResource;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'leave_type',
        'start_date',
        'end_date',
        'total_days',
        'details',
        'emergency_contact_person',
        'emergency_contact_number',
        'emergency_contact_address',
    ];

    public function approvalRequests()
    {
        $approval_requests = ApprovalRequest::where('approval_for', '=', 'leave')
                                            ->where('related_id', '=', $this->id)
                                            ->orderBy('line', 'DESC')->get();
        return ApprovalRequestsResource::collection($approval_requests);
    }

    public function applicant()
    {
        $applicant = User::find($this->applicant_id);
        return new UserShortInfoResource($applicant);
    }

    public function attachments()
    {
        $attachments = Attachments::where('related_to', '=', 'leave')
                                    ->where('related_id', '=', $this->id)
                                    ->get();
        return AttachmentsResource::collection($attachments);
    }

    public function applicationStatus()
    {
        $coRe = ApprovalRequest::where('approval_for', '=', 'leave')
                                            ->where('related_id', '=', $this->id)
                                            ->where('need_approval_from', '=', '2010160')
                                            ->first();
        
        if(!$coRe){
            $coRe2 = ApprovalRequest::where('approval_for', '=', 'leave')
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

    public function attch()
    {
        return Attachments::where('related_to', '=', 'leave')
                            ->where('related_id', '=', $this->id)
                            ->get();
    }

    public function approvers()
    {
        return ApprovalRequest::where('approval_for', '=', 'leave')
                                ->where('related_id', '=', $this->id)
                                ->orderBy('line', 'DESC')->get();
    }
}
