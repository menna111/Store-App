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
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->float('price')->default(0);
            $table->float('sale_price')->nullable()->default(0);
            $table->unsignedSmallInteger('quantity');
            $table->text('description');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('category_id')->on('categories')
                ->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('user_id')->on('users')
                ->references('id')->cascadeOnUpdate()->cascadeOnDelete();

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
