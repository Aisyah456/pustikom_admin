<div class="p-6 space-y-4">
  <h1 class="text-xl font-bold">{{ $surat_id ? 'Edit Surat' : 'Tambah Surat' }}</h1>

  <form wire:submit.prevent="save" class="space-y-4">

    <div>
      <label>Nomor Surat</label>
      <input type="text" wire:model="nomor_surat" class="w-full border rounded p-2">
      @error('nomor_surat')
        <span class="text-red-600">{{ $message }}</span>
      @enderror
    </div>

    <div>
      <label>Asal Surat</label>
      <input type="text" wire:model="asal_surat" class="w-full border rounded p-2">
    </div>

    <div>
      <label>Perihal</label>
      <input type="text" wire:model="perihal" class="w-full border rounded p-2">
    </div>

    <div>
      <label>Tanggal Surat</label>
      <input type="date" wire:model="tanggal_surat" class="w-full border rounded p-2">
    </div>

    <div>
      <label>Tanggal Terima</label>
      <input type="date" wire:model="tanggal_terima" class="w-full border rounded p-2">
    </div>

    <div>
      <label>File Surat (PDF/JPG/PNG)</label>
      <input type="file" wire:model="file_surat">
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
      Simpan
    </button>
  </form>
</div>
