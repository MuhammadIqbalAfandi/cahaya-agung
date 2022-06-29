<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('price');
            $table->unsignedTinyInteger('ppn');
            $table->unsignedInteger('qty');
            $table->string('product_number');
            $table->string('sale_number');
            $table->foreign('sale_number')->references('number')->on('sales');
            $table->foreign('product_number')->references('number')->on('products');
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
        Schema::dropIfExists('sale_details');
    }
};
