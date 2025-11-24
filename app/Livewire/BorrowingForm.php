<?php

namespace App\Livewire;

use App\Models\Borrowing;
use Livewire\Component;
use App\Models\Item;
use App\Models\Faculty;
use App\Models\StudyProgram;
use App\Models\Unit;

class BorrowingForm extends Component
{
    public Borrowing $borrowing;
    public $items;
    public $faculties;
    public $studyPrograms;
    public $units;

    // Properti Form
    public $borrower_name, $borrower_unit_type, $borrower_unit_id, $item_id,
        $borrow_date, $estimated_return_date, $purpose, $quantity, $condition_out;

    protected $rules = [
        'borrower_name' => 'required|string|max:255',
        'borrower_unit_type' => 'required|string|in:App\Models\Faculty,App\Models\StudyProgram,App\Models\Unit',
        'borrower_unit_id' => 'required|integer',
        'item_id' => 'required|integer|exists:items,id',
        'borrow_date' => 'required|date',
        'estimated_return_date' => 'required|date|after_or_equal:borrow_date',
        'purpose' => 'required|string',
        'quantity' => 'required|integer|min:1',
        'condition_out' => 'required|string|max:255',
    ];

    public function mount(Borrowing $borrowing)
    {
        // Inisialisasi model
        $this->borrowing = $borrowing ?? new Borrowing();

        // Load data dropdown
        $this->items = Item::where('current_stock', '>', 0)->get();
        $this->faculties = Faculty::all();
        $this->studyPrograms = StudyProgram::all();
        $this->units = Unit::all();

        // Jika mode Edit, isi properti form
        if ($this->borrowing->exists) {
            $this->fill($this->borrowing->toArray());
        }
    }

    public function save()
    {
        $this->validate();

        // 1. Ambil item untuk cek stok
        $item = Item::findOrFail($this->item_id);

        // 2. Logika Khusus Create (Pengurangan Stok)
        if (!$this->borrowing->exists) {
            if ($item->current_stock < $this->quantity) {
                session()->flash('error', 'Stok barang tidak mencukupi.');
                return;
            }
            $item->current_stock -= $this->quantity;
        }
        // Logika Khusus Update (Stok dihitung di model/service yang lebih kompleks)
        // Untuk contoh sederhana ini, kita asumsikan update tidak mengubah quantity/stok.

        // 3. Simpan data peminjaman
        $this->borrowing->fill([
            'borrower_name' => $this->borrower_name,
            'borrower_unit_type' => $this->borrower_unit_type,
            'borrower_unit_id' => $this->borrower_unit_id,
            'item_id' => $this->item_id,
            'borrow_date' => $this->borrow_date,
            'estimated_return_date' => $this->estimated_return_date,
            'purpose' => $this->purpose,
            'quantity' => $this->quantity,
            'condition_out' => $this->condition_out,
            'status' => $this->borrowing->exists ? $this->borrowing->status : 'Borrowed', // Pastikan status awal 'Borrowed'
            'admin_out' => auth()->user()->name ?? 'PUSTIKOM Admin', // ID atau Nama Admin yang sedang login
        ])->save();

        // 4. Update stok
        $item->save();

        session()->flash('message', 'Peminjaman berhasil disimpan.');
        return redirect()->route('borrowings.index');
    }
    public function render()
    {
        return view('livewire.borrowing-form');
    }
}
