<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->nullable();
            $table->string('slug',255)->nullable();
            $table->float('price')->nullable()->unsigned();
            $table->float('discount_price');
            $table->text('short_description')->nullable();
            $table->integer('qty')->unsigned()->nullable();
            $table->string('shipping',255)->nullable();
            $table->float('weight')->nullable();
            $table->text('description')->nullable();
            $table->text('information')->nullable();
            $table->boolean('status')->default(1);
            $table->string('image_url',255)->nullable();
            //Buoc 1
            // $table->bigInteger('product_category_id')->unsigned();
            $table->unsignedBigInteger('product_category_id');
            //Buoc 2
            $table->foreign('product_category_id')->references('id')->on('product_category');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
