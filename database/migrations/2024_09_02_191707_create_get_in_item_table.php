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
        Schema::create('get_in_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('get_in_id');
            $table->foreign('get_in_id')->references('id')->on('get_in')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items_masters')->onDelete('cascade')->onUpdate('cascade');

            $table->string('quantity');

            $table->unsignedBigInteger('uom_id');
            $table->foreign('uom_id')->references('id')->on('uom_masters')->onDelete('cascade')->onUpdate('cascade');

            $table->string('rate');
            $table->string('amount');
            $table->string('remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('get_in_item');
    }
};
