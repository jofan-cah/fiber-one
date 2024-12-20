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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->string('subs_id')->primary(); // Primary key subs_id
            $table->string('subs_name');
            $table->string('subs_location_maps'); // Menyimpan koordinat dalam format string (longitude, latitude)
            $table->string('odp_id'); // Menyimpan koordinat dalam format string (longitude, latitude)
            $table->foreign('odp_id')
                ->references('odp_id')
                ->on('odps')
                ->onDelete('cascade');
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
        Schema::dropIfExists('subscriptions');
    }
};
