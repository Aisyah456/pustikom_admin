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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();

            // --- KOLOM DATA PEMINJAM ---
            $table->string('borrower_name');

            // Kolom Relasi Polimorfik (Menggantikan borrower_unit_dept)
            $table->unsignedBigInteger('borrower_unit_id');   // ID dari Unit/Prodi/Fakultas
            $table->string('borrower_unit_type'); // Tipe/Nama Tabel Unit/Prodi/Fakultas
            // ---------------------------

            // Relasi Barang (Foreign Key ke tabel 'items')
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');

            // Kolom Peminjaman lainnya...
            $table->dateTime('borrow_date');
            $table->dateTime('estimated_return_date');
            $table->text('purpose');
            $table->integer('quantity');

            $table->string('condition_out');
            $table->enum('status', ['Borrowed', 'Returned', 'Overdue', 'Cancelled'])->default('Borrowed');

            $table->dateTime('actual_return_date')->nullable();
            $table->string('condition_in')->nullable();
            $table->text('notes')->nullable();

            $table->string('admin_out');
            $table->string('admin_in')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
