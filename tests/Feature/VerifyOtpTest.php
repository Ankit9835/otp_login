<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use App\Notifications\OTPNotification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifyOtpTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_submit_otp_and_verified()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $OTP = auth()->user()->cacheTheOtp();

        

        $this->post('/verifyOTP', ['OTP' => $OTP])->assertStatus(302);
        $this->assertDatabaseHas('users', ['isVerified' => 1]);
    }

    public function test_user_can_see_otp_verify_page(){
         $user = factory(User::class)->create();
         $this->actingAs($user);

         $this->get('/verifyOTPPage')->assertStatus(200)
         ->assertSee('Enter OTP');
    }

    public function test_invalid_otp_returns_error_message(){
        $user = factory(User::class)->create();
         $this->actingAs($user);

         $this->post('/verifyOTP', ['OTP' => 'Invalid OTP'])->assertSessionHasErrors();
    }

    public function test_if_no_otp_is_given_then_return_error(){

        $this->withExceptionHandling();
        $user = factory(User::class)->create();
         $this->actingAs($user);

         $this->post('/verifyOTP', ['OTP' => null])->assertSessionHasErrors(['OTP']);
    }

    public function test_it_has_cache_key_for_otp()
    {
        $user = factory(User::class)->create();
        $this->assertEquals($user->OTPkey(), 'OTP_for_1');
    }

    public function test_it_can_send_notification_to_user(){
        $user = factory(User::class)->create();
        Notification::fake();
        $user->sendOtp('via_sms');
        Notification::assertSentTo([$user], OTPNotification::class);
    }
}
