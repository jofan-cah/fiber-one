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
            $table->id('port_id');
            $table->string('odp_id');
            $table->foreign('odp_id')
                ->references('odp_id')
                ->on('odps')
                ->onDelete('cascade');
            $table->string('port_number');  // Nomor port (Port 1, Port 2, dst)
            $table->string('status')->default('available');  // Status port (available, occupied)
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
        Schema::dropIfExists('ports');
    }
};
