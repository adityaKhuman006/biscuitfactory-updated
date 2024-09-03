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
        Schema::create('transfer_material_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transfer_material_id');
            $table->foreign('transfer_material_id')->references('id')->on('transfer_material')->onDelete('cascade')->onUpdate('cascade');

            $table->string('item');
            $table->string('quantity');
            $table->string('uom');
            $table->string('from');
            $table->string('to');
            $table->string('person');
            $table->string('remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_material_item');
    }
};
