<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_login_user_can_not_access_home_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->get('/home')->assertRedirect('/verifyOTPPage');
    }

    public function test_login_user_access_home_page()
    {
        $user = factory(User::class)->create(['isVerified' => 1]);
        $this->actingAs($user);
        $this->get('/home')->assertStatus(200);
    }
}
