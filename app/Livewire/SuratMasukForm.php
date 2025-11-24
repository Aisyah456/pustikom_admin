<?php

namespace App\Livewire;

use App\Models\SuratMasuk;
use Livewire\Component;
use Livewire\WithFileUploads;

class SuratMasukForm extends Component
{
    use WithFileUploads;

    public $surat_id;
    public $nomor_surat, $asal_surat, $perihal, $tanggal_surat, $tanggal_terima, $file_surat;

    public function mount($id = null)
    {
        if ($id) {
            $surat = SuratMasuk::find($id);
            $this->surat_id = $surat->id;
            $this->nomor_surat = $surat->nomor_surat;
            $this->asal_surat = $surat->asal_surat;
            $this->perihal = $surat->perihal;
            $this->tanggal_surat = $surat->tanggal_surat;
            $this->tanggal_terima = $surat->tanggal_terima;
        }
    }

    public function save()
    {
        $this->validate([
            'nomor_surat' => 'required',
            'asal_surat' => 'required',
            'perihal' => 'required',
            'tanggal_surat' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        $data = [
            'nomor_surat' => $this->nomor_surat,
            'asal_surat' => $this->asal_surat,
            'perihal' => $this->perihal,
            'tanggal_surat' => $this->tanggal_surat,
            'tanggal_terima' => $this->tanggal_terima,
        ];

        if ($this->file_surat) {
            $data['file_surat'] = $this->file_surat->store('surat', 'public');
        }

        SuratMasuk::updateOrCreate(['id' => $this->surat_id], $data);

        return redirect()->route('surat-masuk.index');
    }

    public function render()
    {
        return view('livewire.surat-masuk-form');
    }
}
