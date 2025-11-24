<x-layouts.app :title="__('Dashboard')">

  @section('content')
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Tambah Surat Masuk</h1>

      <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
          <label class="block font-medium">Nomor Surat</label>
          <input type="text" name="nomor_surat" class="w-full border rounded p-2" value="{{ old('nomor_surat') }}">
          @error('nomor_surat')
            <p class="text-red-500 text-sm">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block font-medium">Pengirim</label>
          <input type="text" name="pengirim" class="w-full border rounded p-2" value="{{ old('pengirim') }}">
          @error('pengirim')
            <p class="text-red-500 text-sm">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block font-medium">Perihal</label>
          <input type="text" name="perihal" class="w-full border rounded p-2" value="{{ old('perihal') }}">
          @error('perihal')
            <p class="text-red-500 text-sm">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block font-medium">Tanggal Surat</label>
          <input type="date" name="tanggal_surat" class="w-full border rounded p-2" value="{{ old('tanggal_surat') }}">
          @error('tanggal_surat')
            <p class="text-red-500 text-sm">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block font-medium">Keterangan</label>
          <textarea name="keterangan" rows="4" class="w-full border rounded p-2">{{ old('keterangan') }}</textarea>
        </div>

        <div>
          <label class="block font-medium">Upload File Surat (PDF/JPG/PNG)</label>
          <input type="file" name="file_surat" class="w-full border rounded p-2">
          @error('file_surat')
            <p class="text-red-500 text-sm">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex gap-3">
          <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
          <a href="{{ route('surat-masuk.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
        </div>
      </form>
    </div>
  </x-layouts.app>
