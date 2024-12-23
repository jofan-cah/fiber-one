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
        Schema::create('odps', function (Blueprint $table) {
            $table->string('odp_id')->primary();
            $table->string('odc_id')->nullable();
            $table->foreign('odc_id')
                ->references('odc_id')
                ->on('odcs')
                ->onDelete('cascade');
            $table->string('odp_name');
            $table->text('odp_description')->nullable();
            $table->string('odp_location_maps')->nullable();
            $table->string('odp_addres');
            $table->integer('odp_port_capacity');
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
        Schema::dropIfExists('odps');
    }
};
