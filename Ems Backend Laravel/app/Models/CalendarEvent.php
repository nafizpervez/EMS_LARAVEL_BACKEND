<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Http\Resources\UserShortInfoResource;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'created_for',
        'title',
        'description',
        'from',
        'to',
        'day_long_event',
        'event_type',
    ];

    public function createdBy()
    {
        $createdBy = User::find($this->created_by);
        return new UserShortInfoResource($createdBy);
    }

    public function createdFor()
    {
        $createdFor = User::find($this->created_for);
        return new UserShortInfoResource($createdFor);
    }

    public function createdByUser()
    {
        return User::find($this->created_by);
    }

    public function createdForUser()
    {
        return User::find($this->created_for);
    }

    public function eventDate()
    {
        return Carbon::parse($this->from)->format('d-m-Y');
    }

    public function eventStartTime()
    {
        return Carbon::parse($this->from)->format('d-m-Y g:i A');
    }

    public function eventEndTime()
    {
        return Carbon::parse($this->from)->format('d-m-Y g:i A');
    }
}
