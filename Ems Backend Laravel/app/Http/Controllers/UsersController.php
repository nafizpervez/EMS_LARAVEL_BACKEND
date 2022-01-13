<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Http\Resources\UsersResource;
use App\Http\Resources\UserShortInfoResource;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UsersResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasfile('avater')){
            $file_path = 'public/images/avatars';

            $av_path = Storage::put($file_path, $request->file('avater'));

            if(env('APP_DEBUG')){
                $av_path = Str::replace($file_path, 'http://127.0.0.1:8000/api/images', $av_path);
            }else{
                $av_path = Str::replace($file_path, 'https://adnemsbacked.adntel.net/api/images', $av_path);
            }
        }else{
            $av_path = null;
        }

        $user = User::create([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'designation' => $request->designation,
            'grade' => $request->grade,
            'division' => $request->division,
            'department' => $request->department,
            'unit' => $request->unit,
            'sub_unit' => $request->sub_unit,
            'date_of_joining' => $request->date_of_joining,
            'location' => $request->location,
            'blood_group' => $request->blood_group,
            'avater' => $av_path,
            'password' => Hash::make(Str::random(10)),
        ]);

        return response()->json(new UsersResource($user), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json(new UsersResource($user), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if($request->hasfile('avater')){
            $file_path = 'public/images/avatars';

            $av_path = Storage::put($file_path, $request->file('avater'));

            if(env('APP_DEBUG')){
                $av_path = Str::replace($file_path, 'http://127.0.0.1:8000/api/images', $av_path);
            }else{
                $av_path = Str::replace($file_path, 'https://adnemsbacked.adntel.net/api/images', $av_path);
            }
        }else{
            $av_path = null;
        }

        $user->update([
            'employee_id' => is_null($request->employee_id) ? $user->employee_id:$request->employee_id,
            'name' => is_null($request->name) ? $user->name:$request->name,
            'email' => is_null($request->email) ? $user->email:$request->email,
            'contact_number' => is_null($request->contact_number) ? $user->contact_number:$request->contact_number,
            'designation' => is_null($request->designation) ? $user->designation:$request->designation,
            'grade' => is_null($request->grade) ? $user->grade:$request->grade,
            'division' => is_null($request->division) ? $user->division:$request->division,
            'department' => is_null($request->department) ? $user->department:$request->department,
            'unit' => is_null($request->unit) ? $user->unit:$request->unit,
            'sub_unit' =>is_null($request->sub_unit) ? $user->sub_unit:$request->sub_unit,
            'date_of_joining' => is_null($request->date_of_joining) ? $user->date_of_joining:$request->date_of_joining,
            'location' => is_null($request->location) ? $user->location:$request->location,
            'blood_group' => is_null($request->blood_group) ? $user->blood_group:$request->blood_group,
            'avater' => is_null($av_path) ? $user->avater: $av_path,
        ]);

        return response()->json(new UsersResource($user), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message'=> "Employee account deleted",], 200);
    }

    public function deactivate(User $user)
    {
        $user->active = false;
        $user->save();
        return response()->json(new UsersResource($user), 200);
    }

    public function activate(User $user)
    {
        $user->active = true;
        $user->save();
        return response()->json(new UsersResource($user), 200);
    }

    public function changePassword(Request $request, User $user)
    {
        if (! $user || ! Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Your credentials are wrong'], 400);
        }else{
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
        }
        return response()->json(new UsersResource($user), 200);
    }

    
}
