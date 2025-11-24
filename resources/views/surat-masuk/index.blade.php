<x-layouts.app :title="__('Dashboard')">

  @section('content')
    <div class="p-6">

      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Data Surat Masuk</h1>

        <a href="{{ route('surat-masuk.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">
          + Tambah Surat
        </a>
      </div>

      <livewire:surat-masuk-table />

    </div>

    {{-- Script Delete --}}
    <script>
      document.addEventListener('livewire:initialized', () => {
        Livewire.on('delete', data => {
          if (confirm("Yakin ingin menghapus surat ini?")) {
            fetch(`/surat-masuk/${data.id}`, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              }
            }).then(() => location.reload());
          }
        });
      });
    </script>
  </x-layouts.app>
