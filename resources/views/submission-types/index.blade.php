<x-layouts.app :title="__('Pengajuan')">
<div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Manajemen Jenis Pengajuan Surat') }}</flux:heading>

        <div class="mb-6">
            @livewire('submission-type-form')
        </div>

        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            @livewire('submission-type-table') 
        </div>
    </div>
</x-app-layout>