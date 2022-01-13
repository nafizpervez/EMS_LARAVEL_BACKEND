<?php

namespace App\Http\Controllers;

use App\Models\ApprovalRequest;
use Illuminate\Http\Request;
use Mail;

use App\Mail\LeaveProcessingMail;
use App\Mail\ConveyanceProcessingMail;
use App\Mail\PurchaseRequisitionProcessingMail;
use App\Jobs\SendEmailJob;

use App\Http\Resources\ApprovalRequestsResource;


class ApprovalRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApprovalRequestsResource::collection(ApprovalRequest::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApprovalRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApprovalRequest  $approvalRequest
     * @return \Illuminate\Http\Response
     */
    public function show(ApprovalRequest $approvalRequest)
    {
        return response()->json(new ApprovalRequestsResource($approvalRequest), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApprovalRequest  $approvalRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(ApprovalRequest $approvalRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApprovalRequestRequest  $request
     * @param  \App\Models\ApprovalRequest  $approvalRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApprovalRequest $approvalRequest)
    {
        try {
            $approvalRequest->update([
                'status' => is_null($request->status) ? $approvalRequest->status:$request->status,
                'remark' => is_null($request->remark) ? $approvalRequest->status:$request->remark,
            ]);

            if (!is_null($approvalRequest->relatedTo()->user()->email)) {
                $cc = array();

                foreach ($approvalRequest->relatedTo()->approvers() as $approver) {
                    if ($approver->line > $approvalRequest->line) {
                        $approver->update([
                            'status' => is_null($request->status) ? $approvalRequest->status:$request->status,
                        ]);
                    }

                    if (!is_null($approver->approvee()->email) && $approver->line >= $approvalRequest->line) {
                        array_push($cc, $approver->approvee()->email);
                    }                    
                }

                if ($approvalRequest->approval_for == 'leave') {
                    try {
                        dispatch(
                            new SendEmailJob(
                                $approvalRequest->relatedTo()->user()->email, 
                                $cc,
                                new LeaveProcessingMail(
                                    $approvalRequest->relatedTo(), 
                                    $approvalRequest
                                ),
                            ),
                        );
                    } catch (\Throwable $th) {}
                }elseif ($approvalRequest->approval_for == 'conveyance') {
                    try {
                        dispatch(
                            new SendEmailJob(
                                $approvalRequest->relatedTo()->user()->email, 
                                $cc,
                                new ConveyanceProcessingMail(
                                    $approvalRequest->relatedTo(), 
                                    $approvalRequest
                                ),
                            ),
                        );
                    } catch (\Throwable $th) {}
                }else {
                    try {
                        dispatch(
                            new SendEmailJob(
                                $approvalRequest->relatedTo()->user()->email, 
                                $cc,
                                new PurchaseRequisitionProcessingMail(
                                    $approvalRequest->relatedTo(), 
                                    $approvalRequest
                                ),
                            ),
                        );
                    } catch (\Throwable $th) {}
                }
                
            }
            
            return response()->json(new ApprovalRequestsResource($approvalRequest), 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=> $th.''], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApprovalRequest  $approvalRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApprovalRequest $approvalRequest)
    {
        //
    }
}
