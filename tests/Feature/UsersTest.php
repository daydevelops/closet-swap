<?php

namespace Tests\Feature;

use App\Models\Like;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_user_knows_if_it_has_donated() {
        $this->assertFalse(User::factory()->create(['donations'=>0])->hasDonated);
        $this->assertTrue(User::factory()->create(['donations'=>1])->hasDonated);
    }

    /** @test */
    public function a_user_knows_the_link_to_their_profile() {
        $user = User::factory()->create(['handle' => 'foobar']);
        $this->assertEquals('profile/foobar',$user->profile());
    }

    /** @test */
    public function a_user_has_products() {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $prod1 = Product::factory()->create(['user_id' => $user1->id]);
        $prod2 = Product::factory()->create(['user_id' => $user2->id]);
        $this->assertInstanceOf(Product::class,$user1->products->first());
        $this->assertEquals($prod1->id,$user1->products->first()->id);
        $this->AssertCount(1,$user1->products);
    }

    /** @test */
    public function a_user_has_followers() {
        
    }

    /** @test */
    public function a_user_has_follows() {
        
    }

    /** @test */
    public function a_user_has_products_they_have_liked() {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Product::factory()->create(['user_id'=>$user2->id]);
        Product::factory()->create(['user_id'=>$user2->id]);
        $prod = Product::factory()->create(['user_id'=>$user2->id]);
        $this->signIn($user1);

        $this->assertDatabaseCount('likes',0);
        $this->assertCount(0,$user1->fresh()->likes);

        $prod->like();

        $this->assertCount(1,$user1->fresh()->likes);
        $this->assertEquals($prod->id,$user1->fresh()->likes->first()->id);
        $this->assertDatabaseCount('likes',1);
    }

    /** @test */
    public function a_user_can_add_an_avatar() {
        
    }
}
