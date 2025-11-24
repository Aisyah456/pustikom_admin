<?php

namespace App\Http\Controllers;

use App\Models\OutgoingMail;
use Illuminate\Http\Request;

class OutgoingMailController extends Controller
{
    public function index()
    {
        $outgoingMails = OutgoingMail::latest()->paginate(10);
        return view('surat-keluar.index', compact('outgoingMails'));
    }

    public function create()
    {
        return view('surat-keluar.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|unique:outgoing_mails,nomor_surat',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // Handle file upload
        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('outgoing-mails', $fileName, 'public');
            $validated['file_dokumen'] = $filePath;
        }

        OutgoingMail::create($validated);

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil ditambahkan!');
    }

    public function show(OutgoingMail $outgoingMail)
    {
        return view('surat-keluar.show', compact('outgoingMail'));
    }

    public function edit(OutgoingMail $outgoingMail)
    {
        return view('surat-keluar.edit', compact('outgoingMail'));
    }

    public function update(Request $request, OutgoingMail $outgoingMail)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|unique:outgoing_mails,nomor_surat,' . $outgoingMail->id,
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // Handle file upload
        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('outgoing-mails', $fileName, 'public');
            $validated['file_dokumen'] = $filePath;
        }

        $outgoingMail->update($validated);

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil diperbarui!');
    }

    public function destroy(OutgoingMail $outgoingMail)
    {
        $outgoingMail->delete();

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil dihapus!');
    }
}
