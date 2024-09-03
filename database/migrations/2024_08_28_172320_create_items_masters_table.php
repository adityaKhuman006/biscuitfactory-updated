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
        Schema::create('items_masters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('type');
            $table->foreign('type')
                ->references('id')
                ->on('type_masters')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('uom');
            $table->foreign('uom')
                ->references('id')
                ->on('uom_masters')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('uom2');
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_masters');
    }
};
