<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{

    use RefreshDatabase;

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
    public function a_user_has_products_others_have_liked() {
        
    }

    /** @test */
    public function a_user_has_products_they_have_liked() {
        
    }

    /** @test */
    public function a_user_can_add_an_avatar() {
        
    }
}
