<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_product_belongs_to_a_user() {
        $user = User::factory()->create();
        $prod = Product::factory()->create(['user_id' => $user->id]);
        $this->assertInstanceOf(User::class,$prod->user);
        $this->assertEquals($user->id,$prod->user->id);
    }

    /** @test */
    public function a_product_has_a_category() {
        $cat = Category::factory()->create();
        $prod = Product::factory()->create(['category_id' => $cat->id]);
        $this->assertInstanceOf(Category::class,$prod->category);
        $this->assertEquals($cat->id,$prod->user->id);
    }

    /** @test */
    public function a_product_has_likes() {
        
    }

    /** @test */
    public function a_product_has_photos() {
        
    }

    /** @test */
    public function a_product_has_views() {
        
    }

    /** @test */
    public function a_user_can_create_a_new_product() {
        
    }

    /** @test */
    public function a_product_requires_at_least_one_photo() {
        
    }

    /** @test */
    public function a_user_can_edit_a_product() {
        
    }

    /** @test */
    public function a_user_cannot_edit_a_product_they_do_not_own() {
        
    }

    /** @test */
    public function a_user_can_delete_one_of_their_products() {
        
    }

    /** @test */
    public function a_user_cannot_delete_a_product_they_do_not_own() {
        
    }
}
