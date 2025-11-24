<x-layouts.app :title="__('Dashboard')">

  @section('content')
    <div class="container mx-auto px-4 py-8">
      <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
          <h1 class="text-3xl font-bold text-gray-800">Detail Surat Keluar</h1>
          <a href="{{ route('outgoing-mails.index') }}" class="text-gray-600 hover:text-gray-800">Kembali</a>
        </div>

        <!-- Detail Card -->
        <div class="bg-white rounded-lg shadow p-6">
          <div class="grid grid-cols-2 gap-6">
            <!-- Nomor Surat -->
            <div>
              <label class="block text-gray-700 font-bold mb-1">Nomor Surat</label>
              <p class="text-gray-600">{{ $outgoingMail->nomor_surat }}</p>
            </div>

            <!-- Tanggal Surat -->
            <div>
              <label class="block text-gray-700 font-bold mb-1">Tanggal Surat</label>
              <p class="text-gray-600">{{ $outgoingMail->tanggal_surat->format('d/m/Y') }}</p>
            </div>

            <!-- Tujuan -->
            <div>
              <label class="block text-gray-700 font-bold mb-1">Tujuan</label>
              <p class="text-gray-600">{{ $outgoingMail->tujuan }}</p>
            </div>

            <!-- Perihal -->
            <div>
              <label class="block text-gray-700 font-bold mb-1">Perihal</label>
              <p class="text-gray-600">{{ $outgoingMail->perihal }}</p>
            </div>
          </div>

          <!-- Deskripsi -->
          <div class="mt-6">
            <label class="block text-gray-700 font-bold mb-1">Deskripsi</label>
            <p class="text-gray-600">{{ $outgoingMail->deskripsi ?? 'Tidak ada' }}</p>
          </div>

          <!-- File Dokumen -->
          <div class="mt-6">
            <label class="block text-gray-700 font-bold mb-1">File Dokumen</label>
            @if ($outgoingMail->file_dokumen)
              <a href="{{ asset('storage/' . $outgoingMail->file_dokumen) }}" target="_blank"
                class="text-blue-600 hover:text-blue-800 font-semibold">
                Download: {{ basename($outgoingMail->file_dokumen) }}
              </a>
            @else
              <p class="text-gray-600">Tidak ada file</p>
            @endif
          </div>

          <!-- Timestamps -->
          <div class="mt-6 pt-6 border-t border-gray-200 text-sm text-gray-500">
            <p>Dibuat: {{ $outgoingMail->created_at->format('d/m/Y H:i') }}</p>
            <p>Diperbarui: {{ $outgoingMail->updated_at->format('d/m/Y H:i') }}</p>
          </div>

          <!-- Action Buttons -->
          <div class="mt-6 flex gap-4">
            <a href="{{ route('outgoing-mails.edit', $outgoingMail->id) }}"
              class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-6 rounded">
              Edit
            </a>
            <form action="{{ route('outgoing-mails.destroy', $outgoingMail->id) }}" method="POST" class="inline"
              onsubmit="return confirm('Yakin ingin menghapus?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                Hapus
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </x-layouts.app>
