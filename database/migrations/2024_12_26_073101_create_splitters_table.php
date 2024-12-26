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
            $table->id('splitter_id');
            $table->string('odc_id');
            $table->foreign('odc_id')
                ->references('odc_id')
                ->on('odcs')
                ->onDelete('cascade');
            $table->string('type');  // Jenis splitter (misalnya 1:2, 1:4)
            $table->integer('port_count');  // Jumlah port yang tersedia pada splitter
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
        Schema::dropIfExists('splitters');
    }
};
