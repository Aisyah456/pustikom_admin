<?php

namespace Database\Seeders;

use App\Models\Submission;
use App\Models\SubmissionType;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data lama (penting agar seeder tidak menghasilkan duplikat unique key)
        Unit::truncate();
        SubmissionType::truncate();
        Submission::truncate();

        // ------------------------------------
        // 1. UNIT SEEDER (Biro/Fakultas/Prodi)
        // ------------------------------------

        $fakultasTeknik = Unit::create([
            'parent_id' => null,
            'name' => 'Fakultas Teknik',
            'type' => 'Fakultas',
        ]);

        $fakultasEkonomi = Unit::create([
            'parent_id' => null,
            'name' => 'Fakultas Ekonomi dan Bisnis',
            'type' => 'Fakultas',
        ]);

        $biroAset = Unit::create([
            'parent_id' => null,
            'name' => 'Biro Pengelolaan Aset',
            'type' => 'Biro',
        ]);

        $prodiInformatika = Unit::create([
            'parent_id' => $fakultasTeknik->id,
            'name' => 'Prodi Teknik Informatika',
            'type' => 'Prodi',
        ]);

        $prodiManajemen = Unit::create([
            'parent_id' => $fakultasEkonomi->id,
            'name' => 'Prodi Manajemen',
            'type' => 'Prodi',
        ]);


        // ------------------------------------
        // 2. SUBMISSION TYPE SEEDER (Jenis Pengajuan)
        // ------------------------------------

        $typeDana = SubmissionType::create([
            'name' => 'Permohonan Dana Kegiatan',
            'description' => 'Pengajuan anggaran dan proposal kegiatan.',
            'required_fields' => json_encode(['anggaran', 'proposal_file']),
        ]);

        $typeRuangan = SubmissionType::create([
            'name' => 'Izin Peminjaman Ruangan',
            'description' => 'Pengajuan untuk pemakaian ruangan.',
            'required_fields' => json_encode(['ruangan_id', 'waktu_mulai', 'waktu_selesai']),
        ]);

        $typeUmum = SubmissionType::create([
            'name' => 'Surat Pengantar Umum',
            'description' => 'Pengajuan surat pengantar untuk keperluan non-spesifik.',
            'required_fields' => null,
        ]);


        // ------------------------------------
        // 3. SUBMISSIONS SEEDER (Pengajuan Surat)
        // ------------------------------------

        // Contoh Pengajuan 1: Dari Prodi (Anak)
        Submission::create([
            'unit_id' => $prodiInformatika->id,
            'submission_type_id' => $typeDana->id,
            'requester_name' => 'Dr. Budi Santoso',
            'requester_email' => 'budi.santoso@ft.id',
            'subject' => 'Pengajuan Dana Kegiatan Webinar AI 2025',
            'content' => 'Permohonan dana untuk penyelenggaraan webinar nasional kecerdasan buatan.',
            'submission_date' => now()->subDays(5),
            'attachments' => json_encode(['path/proposal_ai.pdf']),
            'status' => 'Disetujui',
            'current_stage' => 'Selesai',
            'reference_number' => 'FT/TI/001/2025',
            'verified_by' => 'Admin Keuangan',
            'verification_notes' => 'Anggaran disetujui 80%.',
        ]);

        // Contoh Pengajuan 2: Dari Fakultas (Induk)
        Submission::create([
            'unit_id' => $fakultasEkonomi->id,
            'submission_type_id' => $typeRuangan->id,
            'requester_name' => 'Siti Nurmala',
            'requester_email' => 'siti.n@feb.id',
            'subject' => 'Peminjaman Ruang Auditorium FEB',
            'content' => 'Peminjaman untuk acara Wisuda Mini tanggal 15 Januari.',
            'submission_date' => now()->subDays(2),
            'attachments' => null,
            'status' => 'Dalam Proses',
            'current_stage' => 'Verifikasi Kabiro Aset',
            'reference_number' => null,
        ]);

        // Contoh Pengajuan 3: Dari Biro
        Submission::create([
            'unit_id' => $biroAset->id,
            'submission_type_id' => $typeUmum->id,
            'requester_name' => 'Andi Wijaya',
            'requester_email' => 'andi.w@aset.id',
            'subject' => 'Permintaan Surat Pengantar Pembelian Server Baru',
            'content' => 'Diperlukan surat pengantar untuk proses pengadaan server baru di data center.',
            'submission_date' => now(),
            'attachments' => json_encode(['path/spesifikasi_server.pdf']),
            'status' => 'Diajukan',
            'current_stage' => 'Verifikasi Kepala Biro',
            'reference_number' => null,
        ]);


        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Aktifkan kembali FK check
    }
}
