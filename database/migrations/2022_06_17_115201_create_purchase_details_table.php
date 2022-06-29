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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('price');
            $table->unsignedTinyInteger('ppn');
            $table->unsignedInteger('qty');
            $table->string('purchase_number');
            $table->string('product_number');
            $table->foreign('purchase_number')->references('number')->on('purchases');
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
        Schema::dropIfExists('purchase_details');
    }
};
