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
        Schema::create('splitters', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('odc_id')->nullable(); // Foreign key to ODC
            $table->integer('port_start'); // Start of the port range
            $table->integer('port_end'); // End of the port range
            $table->string('odp_id')->nullable(); // Foreign key to ODP
            $table->integer('port_number'); // Specific port number
            $table->string('direction'); // Direction for the port
            $table->timestamps();

            // Adding foreign key constraints if needed
            $table->foreign('odc_id')->references('odc_id')->on('odcs')->onDelete('cascade');
            $table->foreign('odp_id')->references('odp_id')->on('odps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('splitters');
    }
};
