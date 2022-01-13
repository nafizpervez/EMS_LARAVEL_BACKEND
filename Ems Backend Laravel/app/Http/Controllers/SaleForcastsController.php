<?php

namespace App\Http\Controllers;

use App\Models\SaleForcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\SaleForcastsResource;
use App\Http\Resources\FunnelValResource;

class SaleForcastsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SaleForcastsResource::collection(SaleForcast::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $saleForcast = SaleForcast::create([
            'name_of_the_account' => $request->name_of_the_account,
            'account_manager_name' => $request->account_manager_name,
            'project_name' => $request->project_name,
            'contact_person' => $request->contact_person,
            'contact_person_mobile' => $request->contact_person_mobile,
            'contact_person_email' => $request->contact_person_email,
            'value_of_the_project' => $request->value_of_the_project,
            'po_date' => $request->po_date,
            'proposal_submission_date' => $request->proposal_submission_date,
            'last_follow_up_date' => $request->last_follow_up_date,
            'expected_closing_date' => $request->expected_closing_date,
            'probability_of_closing' => $request->probability_of_closing,
            'activity_update' => $request->activity_update,
            'remarks' => $request->remarks,
        ]);

        return response()->json(new SaleForcastsResource($saleForcast), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleForcast  $saleForcast
     * @return \Illuminate\Http\Response
     */
    public function show(SaleForcast $saleForcast)
    {
        return response()->json(new SaleForcastsResource($saleForcast), 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleForcast  $saleForcast
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleForcast $saleForcast)
    {   
        $saleForcast->update([
            'name_of_the_account' => is_null($request->name_of_the_account) ? $saleForcast->name_of_the_account:$request->name_of_the_account,
            'account_manager_name' => is_null($request->account_manager_name) ? $saleForcast->account_manager_name:$request->account_manager_name,
            'project_name' => is_null($request->project_name) ? $saleForcast->project_name:$request->project_name,
            'contact_person' => is_null($request->contact_person) ? $saleForcast->contact_person:$request->contact_person,
            'contact_person_mobile' => is_null($request->contact_person_mobile) ? $saleForcast->contact_person_mobile:$request->contact_person_mobile,
            'contact_person_email' => is_null($request->contact_person_email) ? $saleForcast->contact_person_email:$request->contact_person_email,
            'value_of_the_project' => is_null($request->value_of_the_project) ? $saleForcast->value_of_the_project:$request->value_of_the_project,
            'po_date' => is_null($request->po_date) ? $saleForcast->po_date:$request->po_date,
            'proposal_submission_date' => is_null($request->proposal_submission_date) ? $saleForcast->proposal_submission_date:$request->proposal_submission_date,
            'last_follow_up_date' => is_null($request->last_follow_up_date) ? $saleForcast->last_follow_up_date:$request->last_follow_up_date,
            'expected_closing_date' => is_null($request->expected_closing_date) ? $saleForcast->expected_closing_date:$request->expected_closing_date,
            'probability_of_closing' => is_null($request->probability_of_closing) ? $saleForcast->probability_of_closing:$request->probability_of_closing,
            'activity_update' => is_null($request->activity_update) ? $saleForcast->activity_update:$request->activity_update,
            'remarks' => is_null($request->remarks) ? $saleForcast->remarks:$request->remarks,
        ]);

        return response()->json(new SaleForcastsResource($saleForcast), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleForcast  $saleForcast
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleForcast $saleForcast)
    {
        $saleForcast->delete();
        return response()->json(['message'=> "Sale Forcast Record deleted",], 200);
    }
}
