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
        //
        Schema::table('ports', function (Blueprint $table) {
            $table->string('directions')->nullable();  // Kolom untuk menyimpan port yang digunakan oleh subscription
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('ports', function (Blueprint $table) {
            $table->dropColumn('directions');
        });
    }
};
