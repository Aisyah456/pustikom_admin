<x-layouts.app :title="__('Dashboard')">

  @section('content')
    <div class="container mx-auto px-4 py-8">
      <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
          <h1 class="text-3xl font-bold text-gray-800">Edit Surat Keluar</h1>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6">
          <form action="{{ route('outgoing-mails.update', $outgoingMail->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nomor Surat -->
            <div class="mb-4">
              <label for="nomor_surat" class="block text-gray-700 font-bold mb-2">Nomor Surat *</label>
              <input type="text" id="nomor_surat" name="nomor_surat"
                value="{{ old('nomor_surat', $outgoingMail->nomor_surat) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              @error('nomor_surat')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Tanggal Surat -->
            <div class="mb-4">
              <label for="tanggal_surat" class="block text-gray-700 font-bold mb-2">Tanggal Surat *</label>
              <input type="date" id="tanggal_surat" name="tanggal_surat"
                value="{{ old('tanggal_surat', $outgoingMail->tanggal_surat->format('Y-m-d')) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              @error('tanggal_surat')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Tujuan -->
            <div class="mb-4">
              <label for="tujuan" class="block text-gray-700 font-bold mb-2">Tujuan *</label>
              <input type="text" id="tujuan" name="tujuan" value="{{ old('tujuan', $outgoingMail->tujuan) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              @error('tujuan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Perihal -->
            <div class="mb-4">
              <label for="perihal" class="block text-gray-700 font-bold mb-2">Perihal *</label>
              <input type="text" id="perihal" name="perihal" value="{{ old('perihal', $outgoingMail->perihal) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              @error('perihal')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
              <label for="deskripsi" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
              <textarea id="deskripsi" name="deskripsi" rows="5"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('deskripsi', $outgoingMail->deskripsi) }}</textarea>
              @error('deskripsi')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- File Dokumen -->
            <div class="mb-6">
              <label for="file_dokumen" class="block text-gray-700 font-bold mb-2">File Dokumen</label>
              @if ($outgoingMail->file_dokumen)
                <p class="text-sm text-gray-600 mb-2">File saat ini: <a
                    href="{{ asset('storage/' . $outgoingMail->file_dokumen) }}" target="_blank"
                    class="text-blue-600 hover:underline">{{ basename($outgoingMail->file_dokumen) }}</a></p>
              @endif
              <input type="file" id="file_dokumen" name="file_dokumen"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                accept=".pdf,.doc,.docx">
              <p class="text-gray-500 text-sm mt-1">Format: PDF, DOC, DOCX (Max: 5MB) - Kosongkan jika tidak ingin
                mengganti
              </p>
              @error('file_dokumen')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
              <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                Perbarui
              </button>
              <a href="{{ route('outgoing-mails.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                Batal
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </x-layouts.app>
