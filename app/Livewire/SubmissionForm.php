<?php

namespace App\Livewire;

use App\Models\Submission;
use App\Models\SubmissionType;
use App\Models\Unit;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubmissionForm extends Component
{
    use WithFileUploads;

    public $submissionId = null;
    public $isModalOpen = false;

    public $unit_id;
    public $submission_type_id;
    public $requester_name;
    public $requester_email;
    public $subject;
    public $content;
    public $attachments = []; 
    public $units;
    public $submissionTypes;

    protected function rules()
    {
        return [
            'unit_id' => 'required|exists:units,id',
            'submission_type_id' => 'required|exists:submission_types,id',
            'requester_name' => 'required|string|max:255',
            'requester_email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120', 
        ];
    }

    public function mount()
    {
        $this->units = Unit::orderBy('name')->get();
        $this->submissionTypes = SubmissionType::orderBy('name')->get();
    }

    public function store()
    {
        $this->validate();

        $filePaths = [];
        if (!empty($this->attachments)) {
            foreach ($this->attachments as $file) {
                            $filePaths[] = $file->store('submissions', 'public');
            }
        }

        Submission::updateOrCreate(['id' => $this->submissionId], [
            'unit_id' => $this->unit_id,
            'submission_type_id' => $this->submission_type_id,
            'requester_name' => $this->requester_name,
            'requester_email' => $this->requester_email,
            'subject' => $this->subject,
            'content' => $this->content,
            'submission_date' => now(), 
            'status' => 'Diajukan', 
            'attachments' => $filePaths ? json_encode($filePaths) : null,
        ]);

        session()->flash('success', 'Pengajuan surat berhasil diajukan.');
        $this->isModalOpen = false;
        $this->reset(['unit_id', 'submission_type_id', 'requester_name', 'requester_email', 'subject', 'content', 'attachments']);
        $this->dispatch('pg:eventRefreshAll');
    }

    public function render()
    {
        // Pastikan relasi dikirimkan kembali ke view
        return view('livewire.submission-form', [
            'units' => $this->units,
            'submissionTypes' => $this->submissionTypes,
        ]);
    }

}
