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
        Schema::create('pack_masters', function (Blueprint $table) {
            $table->id();

            $table->string('pack_name');
            $table->string('pack_weight');
            // $table->string('pack_weight_uom');

            $table->unsignedBigInteger('pack_weight_uom');
            $table->foreign('pack_weight_uom')->references('id')->on('uom_masters');

            $table->string('no_pf_packet_polybag');

            $table->unsignedBigInteger('packet_polybag_uom');
            $table->foreign('packet_polybag_uom')->references('id')->on('uom_masters');

            $table->string('no_of_polybag_in_cartoon');
            $table->string('no_of_cartoon');

            $table->unsignedBigInteger('no_of_cartoon_uom');
            $table->foreign('no_of_cartoon_uom')->references('id')->on('uom_masters');

            $table->string('weight_of_cartoon');

            $table->unsignedBigInteger('weight_of_cartoon_uom');
            $table->foreign('weight_of_cartoon_uom')->references('id')->on('uom_masters');

            $table->string('loading_in_container');

            $table->string('wrapper_qty');
            $table->string('poly_bag_qty');
            $table->string('box_qty');
            $table->string('tape_qty');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pack_masters');
    }
};
