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
        Schema::create('get_in', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('type_masters')->onDelete('cascade')->onUpdate('cascade');

            $table->string('date');
            $table->string('time');

            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('master_company')->onDelete('cascade')->onUpdate('cascade');

            $table->string('location');
            $table->string('inv_challan_number');
            $table->string('inv_challan_date');
            $table->string('vehicle_number');
            $table->string('mobile');
            $table->string('img');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('get_in');
    }
};
