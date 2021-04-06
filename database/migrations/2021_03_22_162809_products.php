<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
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
            $table->unsignedBigInteger('user_id');
            $table->string('title')->unique();
            $table->string('meta_title')->nullable();
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('size')->default('M')->nullable();
            $table->string('color')->default('black')->nullable();
            $table->string('sku');
            $table->float('price');
            $table->float('discount')->nullable();
            $table->smallInteger('quantity');
            $table->foreignId('products_categories_id')->nullable()->constrained()->references('id')->on('categories')->onDelete('SET NULL');
//            $table->foreignId('products_tags_id')->nullable()->constrained()->references('id')->on('tags')->onDelete('SET NULL');
            $table->timestamps();
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
