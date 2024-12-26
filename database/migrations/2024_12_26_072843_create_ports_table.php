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
        Schema::create('ports', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('olt_id')->nullable(); // Foreign key to OLT
            $table->string('odc_id')->nullable(); // Foreign key to ODC
            $table->string('odp_id')->nullable(); // Foreign key to ODP
            $table->integer('port_number'); // Port number
            $table->enum('status', ['available', 'occupied', 'inactive']); // Status of the port
            $table->timestamps();

            // Adding foreign key constraints if needed
            $table->foreign('olt_id')->references('olt_id')->on('olts')->onDelete('cascade');
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
        Schema::dropIfExists('ports');
    }
};
