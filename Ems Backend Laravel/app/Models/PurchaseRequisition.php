<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Http\Resources\UserShortInfoResource;
use App\Http\Resources\PRItemDetailsResource;
use App\Http\Resources\ApprovalRequestsResource;
use App\Http\Resources\AttachmentsResource;

class PurchaseRequisition extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'serial_id',
        'expanse_type',
        'purpose_of_purchase',
        'user',
        'comment',
    ];

    public function approvalRequests()
    {
        $approval_requests = ApprovalRequest::where('approval_for', '=', 'pr')
                                ->where('related_id', '=', $this->id)
                                ->orderBy('line', 'DESC')->get();
        return ApprovalRequestsResource::collection($approval_requests);
    }

    public function prItems()
    {
        $prItems = PRItemDetail::where('purchase_requisition_id', '=', $this->id)->get();
        return PRItemDetailsResource::collection($prItems);
    }

    public function applicant()
    {
        $applicant = User::find($this->applicant_id);
        return new UserShortInfoResource($applicant);
    }

    public function attachments()
    {
        $attachments = Attachments::where('related_to', '=', 'pr')
                                    ->where('related_id', '=', $this->id)
                                    ->get();
        return AttachmentsResource::collection($attachments);
    }

    public function applicationStatus()
    {
        $status = 'pending';
        $approval_requests = ApprovalRequest::where('approval_for', '=', 'pr')
                                            ->where('related_id', '=', $this->id)
                                            ->get();

        $statusCount = ApprovalRequest::where('approval_for', '=', 'pr')
                                        ->where('related_id', '=', $this->id)->count();
        $approveCount = 0;
        foreach ($approval_requests as $approval_request) {
            if ($approval_request->status == 'rejected') {
                $status = 'rejected';
                break;
            }
            if($approval_request->status == 'approved') {
                $approveCount = $approveCount + 1;
            }
        }

        if($statusCount == $approveCount){
            $status = 'approved';
        }
         
        return $status;
    }

    public function user()
    {
        return User::find($this->applicant_id);
    }

    public function approvers()
    {
        return ApprovalRequest::where('approval_for', '=', 'pr')
                                            ->where('related_id', '=', $this->id)
                                            ->orderBy('line', 'DESC')->get();
    }

    public function items()
    {
        return PRItemDetail::where('purchase_requisition_id', '=', $this->id)->get();
    }

    public function attch()
    {
        return Attachments::where('related_to', '=', 'pr')
                                    ->where('related_id', '=', $this->id)
                                    ->get();
    }

    public function totalEstimatedAmount()
    {
        return PRItemDetail::where('purchase_requisition_id', '=', $this->id)->sum('estimated_total_price');
    }

    public function totalItemQuantity()
    {
        return PRItemDetail::where('purchase_requisition_id', '=', $this->id)->sum('item_quantity');
    }
}
