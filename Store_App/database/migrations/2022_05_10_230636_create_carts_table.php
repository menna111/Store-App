<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();


            $table->foreign('product_id')->on('products')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('user_id')->on('users')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
