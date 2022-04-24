<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->string('title');
            $table->text('description');
            $table->string('gender');
            $table->string('size')->nullable();
            $table->json('tags');
            $table->string('status');
            $table->foreignId('primary_photo_id')->nullable();
            $table->timestamps();
        });

        // seed some products
        if (config('app.env') == 'local') {
            $users = User::select('id')->get();
            $categories = Category::select('id')->get()->pluck('id')->toArray();
            foreach ($users as $u) {
                Product::factory()->create(['user_id'=>$u->id,'category_id'=>$categories[array_rand($categories)]]);
                Product::factory()->create(['user_id'=>$u->id,'category_id'=>$categories[array_rand($categories)]]);
                Product::factory()->create(['user_id'=>$u->id,'category_id'=>$categories[array_rand($categories)]]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
