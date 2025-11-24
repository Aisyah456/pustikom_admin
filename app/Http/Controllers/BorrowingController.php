<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        // Langsung tampilkan Livewire Component BorrowingTable di view
        return view('borrowings.index');
    }

    /**
     * Menampilkan form untuk membuat peminjaman baru.
     */
    public function create()
    {
        // Langsung tampilkan Livewire Form dengan mode Create (tanpa model)
        return view('borrowings.create');
    }

    /**
     * Menampilkan form untuk mengedit peminjaman yang sudah ada.
     */
    public function edit(Borrowing $borrowing)
    {
        // Langsung tampilkan Livewire Form dengan data model yang ada
        return view('borrowings.edit', compact('borrowing'));
    }

    // Metode destroy akan ditangani oleh aksi di PowerGrid, tapi tetap sediakan
    public function destroy(Borrowing $borrowing)
    {
        // Logika delete (opsional, bisa ditangani di PowerGrid)
        // Jika status masih 'Borrowed', harus mengembalikan stok item
        if ($borrowing->status === 'Borrowed') {
            $borrowing->item->current_stock += $borrowing->quantity;
            $borrowing->item->save();
        }

        $borrowing->delete();

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
