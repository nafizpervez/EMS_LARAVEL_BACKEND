<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Http\Requests\StoreCalendarEventRequest;
use App\Http\Requests\UpdateCalendarEventRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Http\Resources\CalendarEventsResource;

use App\Jobs\SendEmailJob;
use App\Mail\TaskAssignmentMail;

class CalendarEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publicEvents = CalendarEvent::where('event_type', '=', 'public')->get();
        $privateEvents = CalendarEvent::where('event_type', '=', 'private')
                                        ->where('created_for', '=', Auth::user()->id)
                                        ->get();

        if (Auth::user()->employee_id == '2010003' || Auth::user()->employee_id == '2020068' ||  Auth::user()->grade == 'B') {
            $assignedEvents = CalendarEvent::all();
        }else{
            $assignedEvents = CalendarEvent::where('event_type', '=', 'assigned')
            ->where('created_for', '=', Auth::user()->id)
            ->orWhere('created_by', '=', Auth::user()->id)->get();
        }

        $merged = $publicEvents->merge($privateEvents);
        $merged = $merged->merge($assignedEvents);
        return CalendarEventsResource::collection($merged);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            
            if ($request->event_type == 'assigned') {
                $createdFor = (int)$request->created_for;
            }else{
                $createdFor = Auth::user()->id;
            }

            $calendar_event = CalendarEvent::create([
                'created_by' => Auth::user()->id,
                'created_for' => $createdFor,
                'title' => $request->title,
                'description' => $request->description,
                'from' => Carbon::parse($request->from),
                'to' => Carbon::parse($request->to),
                'day_long_event' => $request->day_long_event?1:0,
                'event_type' => $request->event_type,
            ]);

            

            if ($calendar_event->event_type == 'assigned') {
                try {
                    dispatch(                    
                        new SendEmailJob(
                            $calendar_event->createdForUser()->email,
                            $calendar_event->createdByUser()->email,
                            new TaskAssignmentMail(
                                $calendar_event
                            ),
                        ),
                    );  
                } catch (\Throwable $th) {

                }        
            }

            return response()->json(new CalendarEventsResource($calendar_event), 200);


        } catch (\Throwable $th) {
            return response()->json(['error'=> $th.'',], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CalendarEvent  $calendar_event
     * @return \Illuminate\Http\Response
     */
    public function show(CalendarEvent $calendar_event)
    {
        return response()->json(new CalendarEventsResource($calendar_event), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CalendarEvent  $calendar_event
     * @return \Illuminate\Http\Response
     */
    public function edit(CalendarEvent $calendar_event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\CalendarEvent  $calendar_event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CalendarEvent $calendar_event)
    {
        try {
            $fromTime = Carbon::createFromFormat('Y-m-d H:i:s', $request->from);
            $toTime = Carbon::createFromFormat('Y-m-d H:i:s', $request->to);

            $calendar_event->update([
                'title' => is_null($request->title) 
                                ? $calendar_event->title
                                :$request->title,
                'description' =>is_null($request->description) 
                                ? $calendar_event->description
                                :$request->description,
                'from' =>is_null($request->from) 
                                ? $calendar_event->from
                                :$fromTime, 
                'to' =>is_null($request->to) 
                                ? $calendar_event->to
                                :$toTime,
                'day_long_event' =>is_null($request->day_long_event) 
                                ? $calendar_event->day_long_event
                                :$request->day_long_event, 
                'event_type' =>is_null($request->event_type) 
                                ? $calendar_event->event_type
                                :$request->event_type,
            ]);
            return response()->json(new CalendarEventsResource($calendar_event), 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=> $th.'',], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CalendarEvent  $calendar_event
     * @return \Illuminate\Http\Response
     */
    public function destroy(CalendarEvent $calendar_event)
    {
        $calendar_event->delete();
        return response()->json(['message'=> "Calander Event has been Removed",], 200);
    }
}
