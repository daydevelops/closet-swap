<?php

namespace Tests\Feature;

use App\Models\Photo;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $this->assertEquals(config('filesystems.product_photos_directory') . '/foobar.png', $p->path);
    }
}
