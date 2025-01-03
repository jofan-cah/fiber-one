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
        Schema::create('pakets', function (Blueprint $table) {
            $table->string('pakets_id')->primary(); // Primary key as string
            $table->string('nama_paket'); // Nama paket
            $table->text('description')->nullable(); // Deskripsi (opsional)
            $table->decimal('price', 10, 2)->nullable(); // Harga paket
            $table->string('speed')->nullable(); // Kecepatan internet
            $table->boolean('status')->default(true); // Status (aktif/tidak)
            $table->decimal('discount', 5, 2)->default(0.00); // Diskon persentase
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pakets');
    }
};
