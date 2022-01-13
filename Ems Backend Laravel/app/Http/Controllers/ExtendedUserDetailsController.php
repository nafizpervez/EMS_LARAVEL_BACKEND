<?php

namespace App\Http\Controllers;

use App\Models\ExtendedUserDetail;
use App\Http\Requests\StoreExtendedUserDetailRequest;
use App\Http\Requests\UpdateExtendedUserDetailRequest;
use App\Http\Resources\ExtendedUserDetailResource;

use Illuminate\Support\Facades\Auth;

class ExtendedUserDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $extendedUserDetail = ExtendedUserDetail::where('user_id', '=', Auth::user()->id)->first();
        return new ExtendedUserDetailResource($extendedUserDetail);
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
     * @param  \App\Http\Requests\StoreExtendedUserDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExtendedUserDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExtendedUserDetail  $extendedUserDetail
     * @return \Illuminate\Http\Response
     */
    public function show(ExtendedUserDetail $extendedUserDetail)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExtendedUserDetail  $extendedUserDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(ExtendedUserDetail $extendedUserDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExtendedUserDetailRequest  $request
     * @param  \App\Models\ExtendedUserDetail  $extendedUserDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExtendedUserDetailRequest $request, ExtendedUserDetail $extendedUserDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExtendedUserDetail  $extendedUserDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExtendedUserDetail $extendedUserDetail)
    {
        //
    }
}
