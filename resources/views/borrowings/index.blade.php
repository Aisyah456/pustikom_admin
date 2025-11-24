<x-layouts.app.sidebar :title="$title ?? null">
  <flux:main>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Data Peminjaman') }}
      </h2>
    </x-slot>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('borrowings.create') }}"
          class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
          + Tambah Peminjaman Baru
        </a>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          {{-- Memanggil komponen PowerGrid Table --}}
          @livewire('borrowing-table')
        </div>
      </div>
    </div>
  </flux:main>
</x-layouts.app.sidebar>
