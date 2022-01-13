<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\TestMail;

class MailsController extends Controller
{
    public function testMail()
    {
        $details = [
            'title' => 'Test Mail from Mobashyer Hossain',
            'body' => 'This is a test mail using adntechnologie',
        ];

        try {
            Mail::to("hossain.mobashyer007@gmail.com")->send(new TestMail($details));
        } catch (Throwable $th) {
            return response()->json(['Error'=> $th->getMessage()], 400);
        }
       

        return response()->json(['Message'=> 'Email Sent'], 200);
    }
}
