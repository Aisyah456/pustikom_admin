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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            // Foreign Keys ke Unit dan Tipe Pengajuan
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->foreignId('submission_type_id')->constrained('submission_types')->onDelete('cascade');

            // Data Requester (Pengganti FK User)
            $table->string('requester_name');
            $table->string('requester_email');

            // Detail Pengajuan
            $table->string('subject');
            $table->text('content');
            $table->date('submission_date');

            // Data File/Lampiran (Terkonsolidasi)
            $table->json('attachments')->nullable()->comment('Array path file lampiran');

            // Status dan Verifikasi
            $table->string('status')->default('Diajukan')->comment('Diajukan, Dalam Proses, Disetujui, Ditolak');
            $table->string('current_stage')->nullable()->comment('Tahap verifikasi saat ini (e.g., Verifikasi Kabiro)');
            $table->string('reference_number')->nullable()->unique()->comment('Nomor surat resmi yang dikeluarkan');

            // Data Verifikator (Pengganti FK User untuk Riwayat Sederhana)
            $table->string('verified_by')->nullable()->comment('Nama atau ID Verifikator terakhir');
            $table->text('verification_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
