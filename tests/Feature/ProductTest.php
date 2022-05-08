<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Photo;
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

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $prod = Product::factory()->create(['user_id'=>$user2->id]);

        $this->assertDatabaseCount('likes',0);
        $this->assertCount(0,$prod->fresh()->likes);

        $prod->likes()->attach($user1);

        $this->assertCount(1,$prod->fresh()->likes);
        $this->assertEquals($user1->id,$prod->fresh()->likes->first()->id);
        $this->assertDatabaseCount('likes',1);
    }

    /** @test */
    public function a_product_knows_if_it_is_liked() {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $prod = Product::factory()->create(['user_id'=>$user2->id]);
        $this->signIn($user1);

        $this->assertFalse($prod->fresh()->liked);
        $prod->like();
        $this->assertTrue($prod->fresh()->liked);
    }

    /** @test */
    public function a_product_knows_how_many_likes_it_has() {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();
        $user4 = User::factory()->create();
        $prod = Product::factory()->create(['user_id'=>$user4->id]);
        $this->signIn($user1);
        $prod->like();
        $this->assertEquals(1,Product::find($prod->id)->withCount('likes')->get()->first()->likes_count);
        $this->signIn($user2);
        $prod->like();
        $this->assertEquals(2,Product::find($prod->id)->withCount('likes')->get()->first()->likes_count);
        $this->signIn($user3);
        $prod->like();
        $this->assertEquals(3,Product::find($prod->id)->withCount('likes')->get()->first()->likes_count);
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

    /** @test */
    public function a_product_has_photos() {
        $prod = Product::factory()->create();
        $p1 = Photo::factory()->create(['product_id'=>$prod->id]);
        $p2 = Photo::factory()->create(['product_id'=>$prod->id]);

        $res = $prod->fresh()->photos;

        $this->assertCount(2,$res);
        $this->AssertInstanceOf(Photo::class,$res[0]);
        $this->AssertInstanceOf(Photo::class,$res[1]);
        $this->AssertEquals($p1->id,$res[0]->id);
        $this->AssertEquals($p2->id,$res[1]->id);
    }

    /** @test */
    public function deleting_a_product_deletes_its_photos() {
        $prod1 = Product::factory()->create();
        $prod2 = Product::factory()->create();
        $photo1 = Photo::factory()->create(['product_id'=>$prod1->id]);
        $photo2 = Photo::factory()->create(['product_id'=>$prod1->id]);
        $photo3 = Photo::factory()->create(['product_id'=>$prod2->id]);

        $this->assertDatabaseCount('products',2);
        $this->assertDatabaseCount('photos',3);
        
        $prod1->delete();

        $this->assertDatabaseCount('products',1);
        $this->assertDatabaseCount('photos',1);
        $this->assertEquals($prod2->id,Product::first()->id);
        $this->assertEquals($photo3->id,Photo::first()->id);
    }

    /** @test */
    public function a_product_can_add_a_photo() {
        $prod = Product::factory()->create();
        $photo = Photo::factory()->create();

        $this->assertCount(0,$prod->fresh()->photos);
        
        $prod->addPhoto($photo);
        
        $this->assertCount(1,$prod->fresh()->photos);
    }

}
