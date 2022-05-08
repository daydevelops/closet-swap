<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikesTest extends TestCase
{
    
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_like_a_product() {
        $prod = Product::factory()->create();
        $this->assertCount(0,$prod->fresh()->likes);
        $this->json('post',route('products.like',$prod->id))->assertstatus(401);
        $this->assertCount(0,$prod->fresh()->likes);
    }

    /** @test */
    public function a_guest_cannot_unlike_a_product() {
        $prod = Product::factory()->create();
        $this->assertCount(0,$prod->fresh()->likes);
        $this->json('delete',route('products.unlike',$prod->id))->assertstatus(401);
        $this->assertCount(0,$prod->fresh()->likes);
    }

    /** @test */
    public function a_product_can_be_liked() {
        $prod = Product::factory()->create();
        $this->signIn();
        $this->assertCount(0,$prod->fresh()->likes);
        $this->json('post',route('products.like',$prod->id))->assertstatus(200);
        $this->assertCount(1,$prod->fresh()->likes);
        $this->assertEquals(auth()->id(),$prod->fresh()->likes->first()->id);
    }

    /** @test */
    public function a_product_can_be_unliked() {
        $prod = Product::factory()->create();
        $this->signIn();
        $prod->like();
        $this->assertCount(1,$prod->fresh()->likes);
        $this->json('delete',route('products.unlike',$prod->id))->assertstatus(200);
        $this->assertCount(0,$prod->fresh()->likes);
    }

    /** @test */
    public function a_product_can_only_be_liked_once() {
        $prod = Product::factory()->create();
        $this->signIn();
        $this->assertCount(0,$prod->fresh()->likes);
        $this->json('post',route('products.like',$prod->id))->assertstatus(200);
        $this->assertCount(1,$prod->fresh()->likes);
        $this->json('post',route('products.like',$prod->id))->assertstatus(401);
        $this->assertCount(1,$prod->fresh()->likes);
    }

    /** @test */
    public function a_user_cannot_like_their_own_product() {
        $prod = Product::factory()->create();
        $this->signIn($prod->user);
        $this->assertCount(0,$prod->fresh()->likes);
        $this->json('post',route('products.like',$prod->id))->assertstatus(401);
        $this->assertCount(0,$prod->fresh()->likes);
    }
 
    /** @test */
    public function a_user_cannot_unlike_their_own_product() {
        $prod = Product::factory()->create();
        $this->signIn($prod->user);
        $this->assertCount(0,$prod->fresh()->likes);
        $this->json('delete',route('products.unlike',$prod->id))->assertstatus(401);
        $this->assertCount(0,$prod->fresh()->likes);
    }

    /** @test */
    public function a_user_can_browse_their_liked_products() {
        
    }

    /** @test */
    public function a_user_is_notified_if_their_product_is_liked_once() {
        
    }

    /** @test */
    public function a_user_is_notified_if_their_product_is_liked_5_times() {
        
    }

    /** @test */
    public function a_user_is_notified_if_their_product_is_liked_10_times() {
        
    }

    /** @test */
    public function a_user_is_notified_if_their_product_is_liked_50_times() {
        
    }

    /** @test */
    public function a_user_is_notified_if_their_product_is_liked_100_times() {
        
    }
}
