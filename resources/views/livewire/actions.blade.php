<div class="flex gap-2">
  <button wire:click="$dispatch('edit', { id: {{ $row['id'] }} })"
    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
    Edit
  </button>
  <button wire:click="$dispatch('delete', { id: {{ $row['id'] }} })"
    onclick="confirm('Yakin hapus data ini?') || event.stopImmediatePropagation()"
    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
    Hapus
  </button>
  <a href="{{ route('item-loans.show', $row['id']) }}"
    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
    Detail
  </a>
</div>
