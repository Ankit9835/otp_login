<?php

namespace App;



use App\Mail\OTPMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Notifications\OTPNotification;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Support\Facades\Session;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','isVerified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function OTP(){
        return Cache::get($this->OTPkey());
    }

    public function OTPkey(){
        return "OTP_for_{$this->id}";
    }

    public function cacheTheOtp(){
         $OTP = rand(100000, 999999);
         Cache::put([$this->OTPkey() => $OTP], now()->addSeconds(60));
         return $OTP;
    }

    public function sendOtp($via){

        $OTP = $this->cacheTheOtp();
        $this->notify(new OTPNotification($via, $OTP));

       /* if($via == 'via_sms'){
           
        } else {
            Mail::to('ankydchrismatic@gmail.com')->send(new OTPMail($this->cacheTheOtp()));
        }*/
        /*$this->cacheTheOtp();*/
         
    }

    public function routeNotificationForKarix()
{
    return $this->phone;
}
}
