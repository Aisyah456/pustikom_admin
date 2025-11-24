<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_loans', function (Blueprint $table) {
            $table->id();

            // Data Peminjam
            $table->string('nama_peminjam');
            $table->string('nip')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('program_studi')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('biro')->nullable();

            // Data Barang
            $table->string('nama_barang');
            $table->integer('jumlah')->default(1);
            $table->string('image')->nullable();

            // Tujuan & Kebutuhan
            $table->text('keperluan')->nullable();

            // Waktu Peminjaman
            $table->date('tanggal_pinjam');
            $table->time('jam_peminjaman')->nullable();

            // Waktu Pengembalian
            $table->date('tanggal_kembali')->nullable();
            $table->time('jam_pengembalian')->nullable();

            // Serah Terima
            $table->string('yang_menyerahkan')->nullable();
            $table->string('penerima_barang')->nullable();

            // Status
            $table->enum('status', ['pending', 'dipinjam', 'selesai'])->default('pending');

            // Upload File (Opsional)
            $table->string('lampiran')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_loans');
    }
};
