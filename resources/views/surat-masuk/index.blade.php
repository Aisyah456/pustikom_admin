<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
      
@section('title', 'Tugas & Fungsi')

@section('content')
    <div class="flex items-center justify-between px-5 py-3 lg:px-10">
        <h1 class="text-2xl font-bold lg:text-3xl">Tugas & Fungsi</h1>

        @php
            // Diasumsikan $duties adalah array atau koleksi yang dilewatkan dari controller
            $count = count($duties->data ?? []); 
        @endphp

        @if ($count == 0)
            <a href="{{ route('surat-masuk.create') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none bg-primary text-primary-foreground hover:bg-primary/90 h-10 py-2 px-4 text-xs">
                Tambah Tugas Pokok & Fungsi
            </a>
        @else
            <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none bg-gray-500 text-white h-10 py-2 px-4" disabled>
                Maksimal Satu Data
            </button>
        @endif
    </div>

    {{-- 
        PERHATIAN: 
        Komponen <DataTable> dan logika columns (dari Inertia/React) tidak bisa 
        diterjemahkan langsung ke Blade. Anda harus menggantinya dengan tabel HTML 
        tradisional atau library DataTables berbasis jQuery/JavaScript.
        
        Berikut adalah contoh struktur tabel dasar:
    --}}
    <div class="mx-5 my-5 lg:mx-10">
        <div class="border rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tugas
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fungsi
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Loop data --}}
                    @forelse ($duties->data ?? [] as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $item['id'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item['task'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item['function'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                {{-- Link Aksi (Edit, Hapus) --}}
                                <a href="{{ route('duty.edit', $item['id']) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                Belum ada data tugas dan fungsi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
    
    </div>
@endsection
  </flux:main>
</x-layouts.app.sidebar>