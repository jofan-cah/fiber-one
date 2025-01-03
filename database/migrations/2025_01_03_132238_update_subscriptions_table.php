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
            $table->string("pakets_id")->nullable();

            $table->foreign('pakets_id')->references('pakets_id')->on('pakets')->onDelete('cascade');
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
        Schema::table('subscriptions', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['pakets_id']);

            // Then drop the column
            $table->dropColumn('pakets_id');
        });
    }
};
