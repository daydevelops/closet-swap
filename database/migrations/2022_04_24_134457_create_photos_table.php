<?php

use App\Models\Photo;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('file_name')->default('default_product_image.jpeg');
            $table->timestamps();
        });


        // seed some products
        if (config('app.env') == 'local') {
            $prods = Product::select('id')->get();
            foreach ($prods as $p) {
                $photo = Photo::factory()->create(['product_id'=>$p->id]);
                Photo::factory()->create(['product_id'=>$p->id]);
                Photo::factory()->create(['product_id'=>$p->id]);
                $p->update(['primary_photo_id'=>$photo->id]);
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
        Schema::dropIfExists('photos');
    }
}
