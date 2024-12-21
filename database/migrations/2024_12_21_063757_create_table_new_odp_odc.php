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
        // Menambahkan kolom parent_odc_id ke tabel ODCs
        Schema::table('odcs', function (Blueprint $table) {
            $table->string('parent_odc_id')->nullable()->after('olt_id');

            // Menambahkan foreign key untuk parent_odc_id
            $table->foreign('parent_odc_id')
                ->references('odc_id')
                ->on('odcs')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        // Menambahkan kolom olt_id dan parent_odp_id ke tabel ODPs
        Schema::table('odps', function (Blueprint $table) {
            // Menambahkan kolom olt_id untuk koneksi langsung ke OLT
            $table->string('olt_id')->nullable()->after('odc_id');

            // Menambahkan kolom parent_odp_id untuk ODP yang terhubung ke ODP lain
            $table->string('parent_odp_id')->nullable()->after('olt_id');

            // Menambahkan foreign key untuk olt_id
            $table->foreign('olt_id')
                ->references('olt_id')
                ->on('olts')
                ->onDelete('set null')
                ->onUpdate('cascade');

            // Menambahkan foreign key untuk parent_odp_id
            $table->foreign('parent_odp_id')
                ->references('odp_id')
                ->on('odps')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        // Menghapus foreign key dan kolom dari tabel ODPs
        Schema::table('odps', function (Blueprint $table) {
            $table->dropForeign(['parent_odp_id']);
            $table->dropForeign(['olt_id']);
            $table->dropColumn('parent_odp_id');
            $table->dropColumn('olt_id');
        });

        // Menghapus foreign key dan kolom dari tabel ODCs
        Schema::table('odcs', function (Blueprint $table) {
            $table->dropForeign(['parent_odc_id']);
            $table->dropColumn('parent_odc_id');
        });
    }
};
