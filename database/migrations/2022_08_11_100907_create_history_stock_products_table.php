<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("history_stock_products", function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("price");
            $table->integer("qty");
            $table->unsignedTinyInteger("ppn");
            $table->string("product_number");
            $table
                ->foreign("product_number")
                ->references("number")
                ->on("products");
            $table->string("sale_number")->nullable();
            $table
                ->foreign("sale_number")
                ->references("number")
                ->on("sales");
            $table->string("purchase_number")->nullable();
            $table
                ->foreign("purchase_number")
                ->references("number")
                ->on("purchases");
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
        Schema::dropIfExists("history_stocks");
    }
};
