<?php

namespace App\Livewire;

use App\Models\SubmissionType;
use App\Models\Unit;
use Livewire\Component;

class UnitForm extends Component
{
    public function render()
    {
        $units = Unit::orderBy('name')->get();
        $submissionTypes = SubmissionType::orderBy('name')->get();

        return view('livewire.submission-form', [ // Sesuaikan nama view di sini
            'units' => $units,
            'submissionTypes' => $submissionTypes,
        ]);
    }

    public function store()
    {
        // ... validasi

        Unit::updateOrCreate(['id' => $this->unitId], [
            'name' => $this->name,
            'type' => $this->type,
            'parent_id' => $this->parent_id ?: null, // Simpan null jika tidak ada parent
        ]);
        // ...
    }
}
