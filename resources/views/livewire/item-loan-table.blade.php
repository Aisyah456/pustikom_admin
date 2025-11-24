<div class="p-6">
  <div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Manajemen Peminjaman Barang</h1>
    <button wire:click="$dispatch('openCreateModal')"
      class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
      + Tambah Peminjaman
    </button>
  </div>

  <div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <livewire:powergrid-item-loan />
  </div>

  <!-- Modal Create/Edit -->
  <livewire:item-loan-form />
</div>
