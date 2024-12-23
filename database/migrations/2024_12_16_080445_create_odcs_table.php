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
        Schema::create('odcs', function (Blueprint $table) {
            $table->string('odc_id')->primary();
            $table->string('olt_id')->nullable();
            $table->foreign('olt_id')
                ->references('olt_id')
                ->on('olts')
                ->onDelete('cascade');

            $table->string('odc_name');
            $table->text('odc_description')->nullable();
            $table->string('odc_location_maps')->nullable();
            $table->string('odc_addres');
            $table->integer('odc_port_capacity');
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
        Schema::dropIfExists('odcs');
    }
};
