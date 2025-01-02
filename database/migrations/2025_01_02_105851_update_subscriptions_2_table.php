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
        Schema::table("subscriptions", function (Blueprint $table)
        {
            $table->string("sn")->nullable();
            $table->string("type_modem")->nullable();
        });

        Schema::table('olts', function (Blueprint $table) {
            $table->string('type_olt')->nullable();
        });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('sn');
            $table->dropColumn('type_modem');
        });

        Schema::table('olts', function (Blueprint $table) {
            $table->dropColumn('type_olt');
        });
    }
};
