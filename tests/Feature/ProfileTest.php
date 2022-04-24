<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_their_own_profile_page() {
        $this->signIn();
        $me = auth()->user();

        $products = Product::factory(3)->create(['user_id'=>$me->id]);

        $res = $this->json('get',$me->profile())->assertStatus(200);

        $res->assertSee($me->name);
        $res->assertSee($me->handle);
        $res->assertSee($me->bio);
        $res->assertDontSee($me->email);
        foreach ($products as $p) {
            $res->assertSee($p->title);
        }
    }

    /** @test */
    public function a_user_can_view_another_users_profile_page() {
        $this->signIn();
        $user = User::factory()->create();
        $res = $this->json('get',$user->profile())->assertStatus(200);

        $products = Product::factory(3)->create(['user_id'=>$user->id]);

        $res = $this->json('get',$user->profile())->assertStatus(200);

        $res->assertSee($user->name);
        $res->assertSee($user->handle);
        $res->assertSee($user->bio);
        $res->assertDontSee($user->email);
        foreach ($products as $p) {
            $res->assertSee($p->title);
        }
    }
}
