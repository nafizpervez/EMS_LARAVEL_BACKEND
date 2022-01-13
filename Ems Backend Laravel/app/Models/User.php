<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Resources\TodosResource;
use App\Http\Resources\LeavesResource;
use App\Http\Resources\AllotedLeaveResource;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'employee_id',
        'name',
        'contact_number',
        'email',
        'designation',
        'grade',
        'division',
        'department',
        'unit',
        'sub_unit',
        'date_of_joining',
        'location',
        'blood_group',
        'avater',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

  
    /**
     * The todos that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function todos()
    {
        $todos = Todo::where('user_id', '=', $this->id)->orderBy('created_at', 'DESC')->get();
        return TodosResource::collection($todos );
    }

    public function leaveApplications()
    {
        $todos = Leave::where('applicant_id', '=', $this->id)->orderBy('created_at', 'DESC')->get();
        return LeavesResource::collection($todos );
    }

    public function extendedDetails()
    {
        return ExtendedUserDetail::where('user_id', '=', $this->id)->first();
    }

    public function extendedDetailResource()
    {
        $details =  ExtendedUserDetail::where('user_id', '=', $this->id)->first();
        return new ExtendedUserDetailResource($details);
    }

    public function allotedLeave()
    {
        $allotedLeaves =  AllotedLeave::where('alloted_for', '=', $this->employee_id)->first();
        return new AllotedLeaveResource($allotedLeaves);
    }
}
