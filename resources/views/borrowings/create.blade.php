<x-layouts.app.sidebar :title="$title ?? null">
  <flux:main>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Buat Peminjaman Baru') }}
      </h2>
    </x-slot>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-xl sm:rounded-lg">
          {{-- Memanggil komponen Livewire Form --}}
          @livewire('borrowing-form')
        </div>
      </div>
    </div>
  </flux:main>
</x-layouts.app.sidebar>
