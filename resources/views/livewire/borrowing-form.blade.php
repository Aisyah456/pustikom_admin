<div>
  <form wire:submit.prevent="save" class="space-y-6">
    @csrf

    @if (session()->has('message'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('message') }}</span>
      </div>
    @endif
    @if (session()->has('error'))
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
      </div>
    @endif

    <h3 class="text-lg font-medium leading-6 text-gray-900">Detail Peminjam</h3>
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">

      <div>
        <label for="borrower_name" class="block text-sm font-medium text-gray-700">Nama Peminjam</label>
        <input type="text" id="borrower_name" wire:model.defer="borrower_name"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('borrower_name')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
      </div>

      <div>
        <label for="borrower_unit_type" class="block text-sm font-medium text-gray-700">Tipe Unit</label>
        <select id="borrower_unit_type" wire:model.live="borrower_unit_type"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
          <option value="">-- Pilih Tipe --</option>
          <option value="App\Models\Faculty">Fakultas</option>
          <option value="App\Models\StudyProgram">Program Studi</option>
          <option value="App\Models\Unit">Unit Lain</option>
        </select>
        @error('borrower_unit_type')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
      </div>

      <div>
        <label for="borrower_unit_id" class="block text-sm font-medium text-gray-700">Nama Unit/Prodi/Fakultas</label>
        <select id="borrower_unit_id" wire:model.defer="borrower_unit_id"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
          <option value="">-- Pilih Unit --</option>
          @if ($borrower_unit_type === 'App\Models\Faculty')
            @foreach ($faculties as $unit)
              <option value="{{ $unit->id }}">{{ $unit->name }}</option>
            @endforeach
          @elseif ($borrower_unit_type === 'App\Models\StudyProgram')
            @foreach ($studyPrograms as $unit)
              <option value="{{ $unit->id }}">{{ $unit->name }} ({{ $unit->faculty->code ?? 'N/A' }})</option>
            @endforeach
          @elseif ($borrower_unit_type === 'App\Models\Unit')
            @foreach ($units as $unit)
              <option value="{{ $unit->id }}">{{ $unit->name }}</option>
            @endforeach
          @endif
        </select>
        @error('borrower_unit_id')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
      </div>
    </div>

    <h3 class="text-lg font-medium leading-6 text-gray-900 pt-6">Detail Peminjaman</h3>
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-4">

      <div>
        <label for="item_id" class="block text-sm font-medium text-gray-700">Barang Dipinjam</label>
        <select id="item_id" wire:model.defer="item_id"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
          <option value="">-- Pilih Barang --</option>
          @foreach ($items as $item)
            <option value="{{ $item->id }}">{{ $item->name }} (Stok: {{ $item->current_stock }})</option>
          @endforeach
        </select>
        @error('item_id')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
      </div>

      <div>
        <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah Pinjam</label>
        <input type="number" id="quantity" wire:model.defer="quantity" min="1"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
        @error('quantity')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
      </div>

      <div>
        <label for="borrow_date" class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
        <input type="date" id="borrow_date" wire:model.defer="borrow_date"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
        @error('borrow_date')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
      </div>

      <div>
        <label for="estimated_return_date" class="block text-sm font-medium text-gray-700">Estimasi Kembali</label>
        <input type="date" id="estimated_return_date" wire:model.defer="estimated_return_date"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
        @error('estimated_return_date')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
      </div>
    </div>

    <div>
      <label for="purpose" class="block text-sm font-medium text-gray-700">Tujuan Peminjaman</label>
      <textarea id="purpose" rows="3" wire:model.defer="purpose"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"></textarea>
      @error('purpose')
        <span class="text-red-500 text-xs">{{ $message }}</span>
      @enderror
    </div>

    <div>
      <label for="condition_out" class="block text-sm font-medium text-gray-700">Kondisi Saat Dipinjam</label>
      <input type="text" id="condition_out" wire:model.defer="condition_out"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" value="Baik">
      @error('condition_out')
        <span class="text-red-500 text-xs">{{ $message }}</span>
      @enderror
    </div>

    <div class="flex justify-end pt-4 border-t border-gray-200">
      <button type="submit"
        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        {{ $borrowing->exists ? 'Update Peminjaman' : 'Simpan Peminjaman' }}
      </button>
    </div>
  </form>
</div>
