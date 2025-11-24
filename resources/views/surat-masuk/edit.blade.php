<x-layouts.app :title="__('Dashboard')">

  @section('content')
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Edit Surat Masuk</h1>

      <form action="{{ route('surat-masuk.update', $surat->id) }}" method="POST" enctype="multipart/form-data"
        class="space-y-4">
        @csrf
        @method('PUT')

        <div>
          <label class="block font-medium">Nomor Surat</label>
          <input type="text" name="nomor_surat" class="w-full border rounded p-2"
            value="{{ old('nomor_surat', $surat->nomor_surat) }}">
          @error('nomor_surat')
            <p class="text-red-500 text-sm">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block font-medium">Pengirim</label>
          <input type="text" name="pengirim" class="w-full border rounded p-2"
            value="{{ old('pengirim', $surat->pengirim) }}">
          @error('pengirim')
            <p class="text-red-500 text-sm">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block font-medium">Perihal</label>
          <input type="text" name="perihal" class="w-full border rounded p-2"
            value="{{ old('perihal', $surat->perihal) }}">
          @error('perihal')
            <p class="text-red-500 text-sm">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block font-medium">Tanggal Surat</label>
          <input type="date" name="tanggal_surat" class="w-full border rounded p-2"
            value="{{ old('tanggal_surat', $surat->tanggal_surat) }}">
          @error('tanggal_surat')
            <p class="text-red-500 text-sm">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block font-medium">Keterangan</label>
          <textarea name="keterangan" rows="4" class="w-full border rounded p-2">{{ old('keterangan', $surat->keterangan) }}</textarea>
        </div>

        <div>
          <label class="block font-medium">Upload File Surat Baru (opsional)</label>
          <input type="file" name="file_surat" class="w-full border rounded p-2">
          @error('file_surat')
            <p class="text-red-500 text-sm">{{ $message }}</p>
          @enderror

          @if ($surat->file_surat)
            <p class="mt-2 text-sm">File saat ini:
              <a href="{{ asset('storage/' . $surat->file_surat) }}" target="_blank" class="text-blue-600 underline">
                Lihat File
              </a>
            </p>
          @endif
        </div>

        <div class="flex gap-3">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
          <a href="{{ route('surat-masuk.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
        </div>
      </form>
    </div>
  @endsection
