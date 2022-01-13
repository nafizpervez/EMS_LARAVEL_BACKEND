<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequisition;
use App\Models\PRItemDetail;
use App\Models\Attachments;
use App\Models\ApprovalRequest;
use App\Models\User;

use App\Jobs\SendEmailJob;
use App\Mail\PurchaseRequisitionSubmissionMail;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Resources\PurchaseRequisitionsResource;


class PurchaseRequisitionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PurchaseRequisitionsResource::collection(PurchaseRequisition::orderBy('created_at', 'desc')->get());
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
     * @param  \App\Http\Requests\StorePurchaseRequisitionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $purchase_requisition = PurchaseRequisition::create([
                'applicant_id' => Auth::user()->id,
                'serial_id' => Str::random(5).'/ADNTL/'.Carbon::now()->format('dmY'),
                'expanse_type' => $request->expanse_type,
                'purpose_of_purchase' => $request->purpose_of_purchase,
                'user' => $request->user,
                'comment' => $request->comment,
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
                    'related_to' => 'pr',
                    'related_id' => $purchase_requisition->id,
                    'attachment_type' => $request->attachment_type.'',
                    'attachment_url' => $av_path,
                ]);
            }

            if(!is_null($request->items)){
                foreach ($request->items as $item) {
                    PRItemDetail::create([
                        'purchase_type' => $item['purchase_type'],
                        'item_description' => $item['item_description'],
                        'item_quantity' =>  $item['item_quantity'],
                        'measurement_of_unit' => array_key_exists('measurement_of_unit', $item) ? $item['measurement_of_unit'] : null,
                        'required_date' =>  array_key_exists('required_date', $item) ? Carbon::createFromFormat('Y-m-d', $item['required_date']) : null,
                        'estimated_unit_price' =>  $item['estimated_unit_price'],
                        'estimated_total_price' =>  $item['estimated_total_price'],
                        'purchase_requisition_id' =>  $purchase_requisition->id,
                    ]);
                }
            }


            if (Auth::user()->grade == 'A' || Auth::user()->grade == 'B' || Auth::user()->grade == 'C') {
                $apprs = array('1010668', '2010171');
            } else {
                $apprs = array('1010668', '2010171', '2010160');
                
                if ($request->is_it_equipment) {
                    array_push($apprs, '2010119');
                }

                if ($request->line_manager_id != '2010160' && $request->line_manager_id != Auth::user()->employee_id) {
                    array_push($apprs, $request->line_manager_id);
                }

                array_push($apprs, '2010003');
            }

            $cc = array();

            foreach ($apprs as $key => $appr) {
                ApprovalRequest::create([
                    'need_approval_from' => $appr,
                    'approval_for' => 'pr',
                    'line' => $key,
                    'related_id' =>$purchase_requisition->id,
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
                        new PurchaseRequisitionSubmissionMail(
                            $purchase_requisition
                        ),
                    ),
                );
    
            } catch (\Throwable $th) {
            }
            
            return response()->json(new PurchaseRequisitionsResource($purchase_requisition), 200);
        } catch (\Throwable $th) {
            return response()->json(['Error'=> $th.''], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseRequisition  $purchase_requisition
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseRequisition $purchase_requisition)
    {
        return response()->json(new PurchaseRequisitionsResource($purchase_requisition), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseRequisition  $purchase_requisition
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseRequisition $purchase_requisition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePurchaseRequisitionRequest  $request
     * @param  \App\Models\PurchaseRequisition  $purchase_requisition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseRequisition $purchase_requisition)
    {
        try {
            $purchase_requisition->update([
                'applicant_id' => $purchase_requisition->applicant_id,
                'expanse_type' =>is_null($request->expanse_type) ? $purchase_requisition->expanse_type:$request->expanse_type,
                'purpose_of_purchase' =>is_null($request->purpose_of_purchase) ? $purchase_requisition->purpose_of_purchase:$request->purpose_of_purchase,
                'user' => is_null($request->user) ? $purchase_requisition->user:$request->user,
                'comment' => is_null($request->comment) ? $purchase_requisition->comment:$request->comment,
            ]);

            if(!is_null($request->items)){
                $prItems = PRItemDetail::where('purchase_requisition_id', '=', $purchase_requisition->id)->get();
                foreach ($prItems as $prItem) {
                    $prItem->delete();
                }
                foreach ($request->items as $item) {
                    PRItemDetail::create([
                        'purchase_type' => $item['purchase_type'],
                        'item_description' => $item['item_description'],
                        'item_quantity' =>  $item['item_quantity'],
                        'measurement_of_unit' => array_key_exists('measurement_of_unit', $item) ? $item['measurement_of_unit'] : null,
                        'required_date' =>  array_key_exists('required_date', $item) ? Carbon::createFromFormat('Y-m-d', $item['required_date']) : null,
                        'estimated_unit_price' =>  $item['estimated_unit_price'],
                        'estimated_total_price' =>  $item['estimated_total_price'],
                        'purchase_requisition_id' =>  $purchase_requisition->id,
                    ]);
                }
            }
            
            return response()->json(new PurchaseRequisitionsResource($purchase_requisition), 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=> $th.''], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseRequisition  $purchase_requisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseRequisition $purchase_requisition)
    {
        foreach ($purchase_requisition->approvers() as $approReq) {
            $approReq->delete();
        }

        foreach ($purchase_requisition->items() as $prItems) {
            $prItems->delete();
        }

        foreach ($purchase_requisition->attch() as $attch) {
            $attch->delete();
        }

        $purchase_requisition->delete();
        return response()->json(['message'=> "Purchase Requisition Request has been Removed",], 200);
    }
}
