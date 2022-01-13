<?php

namespace App\Http\Controllers;

use App\Models\AllotedLeave;
use App\Http\Requests\StoreAllotedLeaveRequest;
use App\Http\Requests\UpdateAllotedLeaveRequest;

class AllotedLeaveController extends Controller
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
     * @param  \App\Http\Requests\StoreAllotedLeaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAllotedLeaveRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AllotedLeave  $allotedLeave
     * @return \Illuminate\Http\Response
     */
    public function show(AllotedLeave $allotedLeave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AllotedLeave  $allotedLeave
     * @return \Illuminate\Http\Response
     */
    public function edit(AllotedLeave $allotedLeave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAllotedLeaveRequest  $request
     * @param  \App\Models\AllotedLeave  $allotedLeave
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAllotedLeaveRequest $request, AllotedLeave $allotedLeave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AllotedLeave  $allotedLeave
     * @return \Illuminate\Http\Response
     */
    public function destroy(AllotedLeave $allotedLeave)
    {
        //
    }
}
