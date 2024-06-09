<?php

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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('make', 100);
            $table->string('model', 255);
            $table->string('year', 100);
            $table->string('mileage', 100);
            $table->string('color', 100);
            $table->string('transmission', 100);
            $table->string('product_description', 255);
            $table->string('product_image', 255);
            $table->string('price', 255);
            $table->tinyInteger('deleted');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
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

?>