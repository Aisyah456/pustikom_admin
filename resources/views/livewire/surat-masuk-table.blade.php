<x-layouts.app.sidebar :title="$title ?? null">
  <flux:main>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Data Surat Masuk</h1>

      <a href="{{ route('surat-masuks.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">
        + Tambah Surat
      </a>

      <livewire:surat-masuk-table />
    </div>
  </flux:main>
</x-layouts.app.sidebar>
