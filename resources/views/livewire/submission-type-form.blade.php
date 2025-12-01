<div>
<div x-data="{ isModalOpen: @entangle('isModalOpen').live }">
    <button wire:click="create()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-150">
        ➕ Tambah Jenis Pengajuan
    </button>
    
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mt-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div x-show="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="isModalOpen" x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <form wire:submit.prevent="store">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            {{ $submissionTypeId ? 'Edit Jenis Pengajuan' : 'Buat Jenis Pengajuan Baru' }}
                        </h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" id="name" wire:model.live="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea id="description" wire:model.live="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
                                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ $submissionTypeId ? 'Update' : 'Simpan' }}
                        </button>
                        <button wire:click="$set('isModalOpen', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Listener untuk event triggerDelete dari PowerGrid (Simulasi SweetAlert/Konfirmasi JS)
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('showDeleteConfirmation', (data) => {
            if (confirm("Apakah Anda yakin ingin menghapus jenis pengajuan ini?")) {
                // Jika user klik OK, kirim event kembali ke Livewire
                Livewire.dispatch('deleteConfirmed', { id: data[0].id });
            }
        });
    });
</script>
</div>
