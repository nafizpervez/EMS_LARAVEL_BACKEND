<?php

namespace App\Http\Controllers;

use App\Models\PRItemDetail;
use App\Http\Requests\StorePRItemDetailRequest;
use App\Http\Requests\UpdatePRItemDetailRequest;

class PRItemDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StorePRItemDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePRItemDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PRItemDetail  $pRItemDetail
     * @return \Illuminate\Http\Response
     */
    public function show(PRItemDetail $pRItemDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PRItemDetail  $pRItemDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(PRItemDetail $pRItemDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePRItemDetailRequest  $request
     * @param  \App\Models\PRItemDetail  $pRItemDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePRItemDetailRequest $request, PRItemDetail $pRItemDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PRItemDetail  $pRItemDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(PRItemDetail $pRItemDetail)
    {
        //
    }
}
