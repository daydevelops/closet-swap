<?php

namespace Tests;

use App\Models\Photo;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

	protected function signIn($user=null) {
		$user = $user ?: User::factory()->create();
		$this->be($user);
		return $user;
	}

	protected function signout() {
		Auth::logout();
	}

	public function seedProducts($count,$attributes) {
        $products = Product::factory($count)->create($attributes);
		$photos = [];
		foreach ($products as $prod) {
			$photos[] = Photo::factory()->create(['product_id' => $prod->id]);
		}

		return compact('products','photos');
	}
}
