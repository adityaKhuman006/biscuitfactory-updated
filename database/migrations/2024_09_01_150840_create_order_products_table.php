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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('product');
            $table->foreign('product')->references('id')->on('product_masters');

            $table->unsignedBigInteger('brand_name');
            $table->foreign('brand_name')->references('id')->on('master_brand');

            $table->unsignedBigInteger('pack_size');
            $table->foreign('pack_size')->references('id')->on('pack_masters');

            $table->string('qty_container'); // loading container
            $table->string('reqd_oty');
            $table->string('container_date');
            $table->string('container_booked');

            $table->unsignedBigInteger('die_name');
            $table->foreign('die_name')->references('id')->on('biscuit_masters');

            $table->string('wrapper_design');
            $table->string('box_design');
            $table->string('approval_from_customer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
