<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

use App\Http\Resources\LeavesResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Mail;

use App\Jobs\SendEmailJob;
use App\Mail\LeaveSubmissionMail;

use App\Models\Attachments;
use App\Models\User;
use App\Models\ApprovalRequest;
use App\Models\AllotedLeave;



class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return LeavesResource::collection(Leave::orderBy('created_at', 'desc')->get());
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
     * @param  \App\Http\Requests\StoreLeaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $startD = Carbon::createFromFormat('Y-m-d', $request->start_date);
            $endD = Carbon::createFromFormat('Y-m-d', $request->end_date);

            $leaf = Leave::create([
                'applicant_id' => Auth::user()->id,
                'leave_type' => $request->leave_type,
                'start_date' =>  $startD,
                'end_date' => $endD,
                'total_days' => $endD->diffInDays($startD) + 1,
                'details' => $request->details,
                'emergency_contact_person' => $request->emergency_contact_person,
                'emergency_contact_number' => $request->emergency_contact_number,
                'emergency_contact_address' => $request->emergency_contact_address,
            ]);

            if($request->hasfile('attachment')){
                $file_path = 'public/files/attachments';

                $av_path = Storage::put($file_path, $request->file('attachment'));

                if(env('APP_DEBUG')){
                    $av_path = Str::replace($file_path, 'http://127.0.0.1:8000/api/attachments', $av_path);
                }else{
                    $av_path = Str::replace($file_path, 'https://adnemsbacked.adntel.net/api/attachments', $av_path);
                }


                Attachments::create([
                    'related_to' => 'leave',
                    'related_id' => $leaf->id,
                    'attachment_type' => $request->attachment_type.'',
                    'attachment_url' => $av_path,
                ]);
            }

            if (Auth::user()->grade == 'A' || Auth::user()->grade == 'B' || Auth::user()->grade == 'C') {
                $apprs = array('1010668');
            } else {
                $apprs = array('2010160');

                if ($request->line_manager_id != '2010160' && $request->line_manager_id != Auth::user()->employee_id) {
                    array_push($apprs, $request->line_manager_id);
                }

                array_push($apprs, '2010003');
            }

            $cc = array();

            foreach ($apprs as $key => $appr) {
                ApprovalRequest::create([
                    'need_approval_from' => $appr,
                    'approval_for' => 'leave',
                    'line' => $key,
                    'related_id' =>$leaf->id,
                ]);

                if($appr != '1010668'){
                    $apprPerson = User::where('employee_id', '=', $appr)->first();
                    
                    if (!is_null($apprPerson->email)) {
                        array_push($cc, $apprPerson->email);
                    }
                }
            }

            $apprPerson = User::where('employee_id', '=', '1010788')->first();

            array_push($cc, $apprPerson->email);
            
            try {
                dispatch(
                    new SendEmailJob(
                        Auth::user()->email, 
                        $cc,
                        new LeaveSubmissionMail(
                            $leaf
                        ),
                    ),
                );
            } catch (\Throwable $th) {
            }

            // $allotedLeaves =  AllotedLeave::where('alloted_for', '=', Auth::user()->employee_id)->first();

            // if(!$allotedLeaves){
            //     $allotedLeaves = AllotedLeave::create([
            //         'alloted_for' => Auth::user()->employee_id,
            //         'total_alloted_leaves' => 34,
            //         'annual_leave' => 0,
            //         'sick_leave' => 0,
            //         'maternity_leave' => 0,
            //         'unpaid_leave' => 0,
            //         'business_year_start' => '2021-07-01',
            //         'business_year_end' => '2022-06-30',
            //     ]);
            // }

            // switch ($request->leave_type) {
            //     case 'sick':
            //         $allotedLeaves->update([
            //             'sick_leave' => $allotedLeaves->sick_leave + $leaf->total_days,
            //         ]);
            //         break;
            //     case 'maternity':
            //         $allotedLeaves->update([
            //             'maternity_leave' => $allotedLeaves->maternity_leave + $leaf->total_days,
            //         ]);
            //         break;
            //     case 'annual':
            //         $allotedLeaves->update([
            //             'annual_leave' => $allotedLeaves->annual_leave + $leaf->total_days,
            //         ]);
            //         break;
            //     case 'unpaid':
            //         $allotedLeaves->update([
            //             'unpaid_leave' => $allotedLeaves->unpaid_leave + $leaf->total_days,
            //         ]);
            //         break;
            //     default:
            //         $allotedLeaves->update([
            //             'sick_leave' => $allotedLeaves->sick_leave + $leaf->total_days,
            //         ]);
            //         break;
            // }   
            

            return response()->json(new LeavesResource($leaf), 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=> $th.'',], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leave  $leaf
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leaf)
    {
        return response()->json(new LeavesResource($leaf), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Leave  $leaf
     * @return \Illuminate\Http\Response
     */
    public function edit(Leave $leaf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLeaveRequest  $request
     * @param  \App\Models\Leave  $leaf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leave $leave)
    {
        try {
            $leaf->update([
                'applicant_id' => $leaf->applicant_id,
                'leave_type' => is_null($request->leave_type) ? $leaf->leave_type:$request->leave_type,
                'start_date' => is_null($request->start_date) ? $conveyance->start_date:Carbon::createFromFormat('Y-m-d', $request->start_date),
                'end_date' => is_null($request->end_date) ? $conveyance->end_date:Carbon::createFromFormat('Y-m-d', $request->end_date),
                'total_days' => is_null($request->total_days) ? $leaf->total_days:$request->total_days,
                'details' => is_null($request->details) ? $leaf->details:$request->details,
                'emergency_contact_person' => is_null($request->emergency_contact_person) ? $leaf->emergency_contact_person:$request->emergency_contact_person,
                'emergency_contact_number' => is_null($request->emergency_contact_number) ? $leaf->emergency_contact_number:$request->emergency_contact_number,
                'emergency_contact_address' => is_null($request->emergency_contact_address) ? $leaf->emergency_contact_address:$request->emergency_contact_address,
            ]);
            return response()->json(new LeavesResource($leaf), 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=> $th.''], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Leave  $leaf
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leaf)
    {
        foreach ($leaf->approvers() as $approReq) {
            $approReq->delete();
        }

        foreach ($leaf->attch() as $attch) {
            $attch->delete();
        }
        
        $leaf->delete();
        return response()->json(['message'=> "Leave Request has been Removed",], 200);
    }

    
}
