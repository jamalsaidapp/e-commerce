<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductsTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('products_id')->nullable()->constrained()->references('id')->on('products')->onDelete('SET NULL');
//            $table->foreignId('tags_id')->nullable()->constrained()->references('id')->on('tags')->onDelete('SET NULL');
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
        Schema::dropIfExists('products_tags');

    }
}
