<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\SaleForcast;
use App\Models\Leave;
use App\Models\LeavesController;
use App\Models\CalendarEvent;

use App\Http\Resources\UserShortInfoResource;
use App\Http\Resources\FunnelValResource;

use Carbon\Carbon;

class InfoController extends Controller
{
    public function employeeCount()
    {
        return response()->json(['employee_count'=> User::count().'',], 200);
    }

    public function allUserSummary()
    {
        return UserShortInfoResource::collection(User::all()); 
    }

    public function funnelVal()
    {
        return FunnelValResource::collection(SaleForcast::orderBy('value_of_the_project', 'ASC')->get());
    }

    public function onLeave()
    {
        $today = Carbon::now()->format('Y-m-d');

        $todaysAbsence = Leave::whereDate('start_date','<=', $today)
                                ->whereDate('end_date','>=', $today)
                                ->distinct('applicant_id')
                                ->count();

        return response()->json([
            'absense'   => $todaysAbsence,
            'presence'  => User::count() -  $todaysAbsence,
        ], 200);
    }

    public function announcements()
    {
        $announcementList = array();

        $today = Carbon::now()->format('Y-m-d');
        $publicEvents = CalendarEvent::where('event_type', '=', 'public')
                                        ->whereDate('from','<=', $today)
                                        ->whereDate('from','>=', $today)
                                        ->get();
        
        foreach ($publicEvents as $publicEvent) {
            array_push($announcementList,['announcement' => $publicEvent->title.'.']);
        }
        
        $joinedToday = User::whereDate('date_of_joining', '=', $today)
                            ->get();
        
        $birthToday = User::whereDate('date_of_birth', '=', $today)
                            ->get();
        
        foreach ($joinedToday as $user) {
            array_push($announcementList, ['announcement' =>'We Congratulate '.$user->name.' for being with ADN for last '.Carbon::now()->diffInYears(Carbon::parse($user->date_of_joining)).' years.']);
        }

        foreach ($birthToday as $user) {
            array_push($announcementList, ['announcement' =>'We wish '.$user->name.' a Happy '.Carbon::now()->diffInYears(Carbon::parse($user->date_of_birth)).'th  Birthday.']);
        }

        return response()->json([
            'announcements' => $announcementList,
        ], 200);
    }
}
