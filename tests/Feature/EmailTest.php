<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailTest extends TestCase
{
     use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_otp_email_is_send_when_user_is_logged_in()
    {

        Mail::fake();

        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $res = $this->post('/login',['email' => $user->email, 'password' => 'password']);

        Mail::assertSent(OTPMail::class);
    }

    public function test_an_otp_email_is_not_send_when_user_credentials_are_incorrect()
    {

        Mail::fake();

        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $res = $this->post('/login',['email' => $user->email, 'password' => 'password']);

        Mail::assertSent(OTPMail::class);
    }

    public function test_otp_is_stored_in_cache_for_the_user()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $res = $this->post('/login',['email' => $user->email, 'password' => 'password']);

        $this->assertNotNull($user->OTP());

    }

}
