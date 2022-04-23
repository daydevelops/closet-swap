<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_their_own_profile_page() {
        $this->signIn();
        $res = $this->json('get',auth()->user()->profile())->assertStatus(200);
    }

    /** @test */
    public function a_user_can_view_another_users_profile_page() {
        $this->signIn();
        $user = User::factory()->create();
        $res = $this->json('get',$user->profile())->assertStatus(200);
    }
}
