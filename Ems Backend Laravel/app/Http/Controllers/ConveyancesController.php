<?php

namespace App\Http\Controllers;

use App\Models\Conveyance;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\ApprovalRequest;
use App\Models\User;

use App\Http\Resources\ConveyancesResource;

use App\Jobs\SendEmailJob;
use App\Mail\ConveyanceSubmissionMail;

class ConveyancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ConveyancesResource::collection(Conveyance::orderBy('created_at', 'desc')->get());
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $conveyance = Conveyance::create([
                'applicant_id' => Auth::user()->id,
                'conveyance_type' => $request->conveyance_type,
                'in_time' => Carbon::parse($request->in_time),
                'out_time' => Carbon::parse($request->out_time),
                'from' => $request->from,
                'to' => $request->to,
                'payable_amount' => $request->payable_amount,
                'details' => $request->details,
            ]);

            if (Auth::user()->grade == 'A' || Auth::user()->grade == 'B' || Auth::user()->grade == 'C') {
                $apprs = array('1010668', '2010171');
            } else {
                $apprs = array('2010171', '2010136', '2010160');

                if ($request->line_manager_id != '2010160' && $request->line_manager_id != Auth::user()->employee_id) {
                    array_push($apprs, $request->line_manager_id);
                }

                array_push($apprs, '2010003');
            }

            $cc = array();

            foreach ($apprs as $key => $appr) {
                ApprovalRequest::create([
                    'need_approval_from' => $appr,
                    'approval_for' => 'conveyance',
                    'line' => $key,
                    'related_id' =>$conveyance->id,
                ]);

                if($appr != '1010668'){
                    $apprPerson = User::where('employee_id', '=', $appr)->first();
                    
                    if (!is_null($apprPerson->email)) {
                        array_push($cc, $apprPerson->email);
                    }
                }
            }
            
            try {
                dispatch(
                    new SendEmailJob(
                        Auth::user()->email, 
                        $cc,
                        new ConveyanceSubmissionMail(
                            $conveyance
                        ),
                    ),
                );
            } catch (\Throwable $th) {
            }
            

            return response()->json(new ConveyancesResource($conveyance), 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=> $th.'',], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conveyance  $conveyance
     * @return \Illuminate\Http\Response
     */
    public function show(Conveyance $conveyance)
    {
        return response()->json(new ConveyancesResource($conveyance), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conveyance  $conveyance
     * @return \Illuminate\Http\Response
     */
    public function edit(Conveyance $conveyance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conveyance  $conveyance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conveyance $conveyance)
    {
        try {
            $conveyance->update([
                'applicant_id' => $conveyance->applicant_id,
                'conveyance_type' => is_null($request->expanse_type) ? $conveyance->expanse_type:$request->expanse_type,
                'in_time' => is_null($request->in_time) ? $conveyance->in_time:Carbon::parse($request->in_time),
                'out_time' => is_null($request->out_time) ? $conveyance->out_time:Carbon::parse($request->out_time),
                'from' => is_null($request->from) ? $conveyance->from:$request->from,
                'to' => is_null($request->to) ? $conveyance->to:$request->to,
                'payable_amount ' => is_null($request->payable_amount) ? $conveyance->payable_amount:$request->payable_amount,
                'details' => is_null($request->details) ? $conveyance->details:$request->details,
             ]);
            return response()->json(new ConveyancesResource($conveyance), 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=> $th.''], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conveyance  $conveyance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conveyance $conveyance)
    {
        foreach ($conveyance->approvers() as $approReq) {
            $approReq->delete();
        }
        $conveyance->delete();
        return response()->json(['message'=> "Conveyance Request has been Removed",], 200);
    }
}
