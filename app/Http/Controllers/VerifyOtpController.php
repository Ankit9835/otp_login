<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OTPRequest;
use Illuminate\Support\Facades\Cache;

class VerifyOtpController extends Controller
{
    //
    public function verify(OTPRequest $request){
    	//dd(request('otp_via'));
    	if(request('OTP') == auth()->user()->OTP()){
    		Auth()->User()->update(['isVerified' => true]);
    		return redirect('/home');
    	}
    	return back()->withErrors('OTP Is Expired Or Invalid');
    }

    public function showVerifyForm(){
    	return view('OTP.verify');
    }
}
