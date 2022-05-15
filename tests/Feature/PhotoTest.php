<?php

namespace Tests\Feature;

use App\Models\Photo;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotoTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_photo_knows_its_product() {
        $prod = Product::factory()->create();
        $photo = Photo::factory()->create(['product_id'=>$prod->id]);

        $res = $photo->fresh()->product;

        $this->AssertInstanceOf(Product::class,$res);
        $this->AssertEquals($prod->id,$res->id);
    }

    /** @test */
    public function a_photo_knows_if_it_is_a_primary_photo() {
        $prod = Product::factory()->create();
        $photo1 = Photo::factory()->create(['product_id'=>$prod->id]);
        $photo2 = Photo::factory()->create(['product_id'=>$prod->id]);

        $prod->update(['primary_photo_id'=>$photo1->id]);

        $this->assertTrue($photo1->is_primary);
        $this->assertFalse($photo2->is_primary);
    }

    /** @test */
    public function a_photo_knows_its_full_path() {
        $p = Photo::factory()->create(['file_name'=>'foobar.png']);
        $this->assertEquals(config('filesystems.disks.photos.root') . '/foobar.png', $p->path);
    }

    /** @test */
    public function a_user_can_upload_a_photo_to_a_product() {
        $this->signIn();

        $prod = Product::factory()->create(['user_id' => auth()->id()]);

        $this->assertCount(0,$prod->fresh()->photos);

        Storage::fake('photos');

        $photo = UploadedFile::fake()->image('test.jpg');
 
        $response = $this->json('post', route('products.photo.store'), [
            'product_id' => $prod->id,
            'photo' => $photo,
        ])->assertStatus(201);
 
        $this->assertEquals($prod->id, Photo::latest()->first()->product_id);
 
        Storage::disk('photos')->assertExists($response->original->file_name);
    }

    /** @test */
    public function a_user_can_not_upload_a_photo_to_a_product_they_do_not_own() {
        
    }

    /** @test */
    public function a_user_can_delete_a_photo_from_a_product() {
        
    }

    /** @test */
    public function a_user_can_not_delete_a_photo_from_a_product_they_do_not_own() {
        
    }
}
