<?php

namespace App\Livewire;

use App\Models\SubmissionType;
use Livewire\Component;

class SubmissionTypeForm extends Component
{
    public $name = '';
    public $description = '';
    public $submissionTypeId = null;
    public $isModalOpen = false;

    // Listeners untuk event dari PowerGrid dan konfirmasi Delete
    protected $listeners = [
        'openEditModal' => 'edit',
        'triggerDelete' => 'confirmDelete',
        'deleteConfirmed' => 'delete' // Diterima dari SweetAlert/JS
    ];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:submission_types,name,' . $this->submissionTypeId,
            'description' => 'nullable|string',
        ];
    }

    public function create()
    {
        $this->reset(['name', 'description', 'submissionTypeId']);
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate();

        SubmissionType::updateOrCreate(['id' => $this->submissionTypeId], [
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash(
            'success',
            $this->submissionTypeId ? 'Jenis Pengajuan Berhasil Diperbarui.' : 'Jenis Pengajuan Berhasil Dibuat.'
        );

        $this->isModalOpen = false;
        $this->dispatch('pg:eventRefreshAll'); // Refresh PowerGrid
    }

    public function edit($data)
    {
        $type = SubmissionType::findOrFail($data['id']);
        $this->submissionTypeId = $type->id;
        $this->name = $type->name;
        $this->description = $type->description;
        $this->isModalOpen = true;
    }

    public function confirmDelete($data)
    {
        $this->dispatch('showDeleteConfirmation', ['id' => $data['id']]); // Trigger SweetAlert di JS
    }

    public function delete($data)
    {
        SubmissionType::find($data['id'])->delete();
        session()->flash('success', 'Jenis Pengajuan Berhasil Dihapus.');
        $this->dispatch('pg:eventRefreshAll');
    }
    
    public function render()
    {
        return view('livewire.submission-type-form');
    }
}
