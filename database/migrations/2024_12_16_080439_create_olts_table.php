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
        Schema::create('olts', function (Blueprint $table) {
            $table->string('olt_id')->primary();
            $table->string('olt_name');
            $table->text('olt_description')->nullable();
            $table->string('olt_location_maps')->nullable();
            $table->string('olt_addres');
            $table->integer('olt_port_capacity');
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
        Schema::dropIfExists('olts');
    }
};
