<x-layouts.app :title="__('Pengajuan')">
    <div class="container mx-auto p-6">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-6">🏢 Manajemen Unit Organisasi</h2>
        
        @if (session()->has('success') || session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 class="@if(session()->has('success')) bg-blue-100 border-blue-400 text-blue-700 @else bg-red-100 border-red-400 text-red-700 @endif border px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') ?? session('error') }}</span>
            </div>
        @endif

        <div class="mb-6">
            {{-- Component untuk Tambah/Edit/Hapus Unit --}}
            @livewire('unit-form') 
        </div>

        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            {{-- Component PowerGrid untuk daftar dan filter Unit --}}
            @livewire('unit-table') 
        </div>
    </div>
</x-app-layout>