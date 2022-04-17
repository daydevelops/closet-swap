<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_category_has_products() {
        $cat1 = Category::factory()->create();
        $cat2 = Category::factory()->create();
        $prods1 = Product::factory(3)->create(['category_id' => $cat1->id])->pluck('id')->toArray();
        $prods2 = Product::factory(3)->create(['category_id' => $cat2->id])->pluck('id')->toArray();
        $this->assertEquals($prods1,$cat1->products->pluck('id')->toArray());
        $this->assertEquals($prods2,$cat2->products->pluck('id')->toArray());
    }
}
