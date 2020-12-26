<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_cache_key_for_otp()
    {
        $user = factory(User::class)->create();
        $this->assertEquals($user->OTPkey(), 'OTP_for_1');
    }
}
