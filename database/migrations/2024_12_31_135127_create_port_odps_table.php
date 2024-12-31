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
        Schema::create('port_odps', function (Blueprint $table) {
            $table->id();
            $table->string('odp_id')->nullable();
            $table->foreign('odp_id')->references('odp_id')->on('odps')->onDelete('cascade');
            $table->integer('port_number'); // Nomor Port
            $table->string('subs_id')->nullable();
            $table->foreign('subs_id')->references('subs_id')->on('subscriptions')->onDelete('cascade');
            $table->timestamps(); // Tanggal pembuatan dan pembarua
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('port_odps');
    }
};
