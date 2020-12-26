<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SMSTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    

     public function test_it_has_cache_key_for_otp()
    {
        $user = factory(User::class)->create();
        $this->assertEquals($user->OTPkey(), 'OTP_for_1');
    }
}
