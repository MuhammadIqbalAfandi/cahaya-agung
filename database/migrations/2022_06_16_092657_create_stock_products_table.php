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
        Schema::create("stock_products", function (Blueprint $table) {
            $table->id();
            $table
                ->string("purchase_number")
                ->nullable()
                ->default(null);
            $table
                ->string("sale_number")
                ->nullable()
                ->default(null);
            $table->integer("qty");
            $table->string("product_number");
            $table
                ->foreign("product_number")
                ->references("number")
                ->on("products");
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
        Schema::dropIfExists("stock_products");
    }
};
