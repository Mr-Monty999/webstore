<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_product', function (Blueprint $table) {
            $table->bigInteger("cart_id")->unsigned();
            $table->bigInteger("product_id")->unsigned();
            $table->primary(["cart_id", "product_id"]);
            $table->timestamps();

            $table->foreign("cart_id")->references("id")->on("carts")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("product_id")->references("id")->on("products")->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_product');
    }
}
