<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Http\Resources\UsersResource;

class AuthController extends Controller
{
    // login
    public function login(Request $request)
    {
        $request->validate([
            'auth_id' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);



        $user_with_email = User::where('email', Str::lower($request->auth_id))->first();

        if(! $user_with_email){
            $phone = '+880-'.substr($request->auth_id, -10);
            $user_with_phone = User::where('contact_number', $phone)->first();
            if (! $user_with_phone) {
                $user_with_emp_id = User::where('employee_id', $request->auth_id)->first();
                if (! $user_with_emp_id) {                    
                    $user = null;
                } else {
                    $user = $user_with_emp_id;
                }
            }
            else{
                $user = $user_with_phone;
            }
        }else{
            $user = $user_with_email;
        }

        if (!$user || ! Hash::check($request->password, $user->password) || !$user->active) {
            return response()->json([
                'message' => 'Your credentials are wrong',
                'status' => 'error',
            ], 200);
        }else{
            return response()->json([
                'token' => $user->createToken($request->device_name)->plainTextToken,
                'status' => 'success',
            ],200);
        }
    }

    public function getUser(Request $request)
    {
        return response()->json([
            'data'=>new UsersResource($request->user()),
            'status' => 'success',
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logged Out',
        ]);
    }
}
