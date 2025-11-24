<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('surat-masuk.index', [
            'title' => 'Surat Masuk',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('surat-masuk.create', [
            'title' => 'Tambah Surat Masuk'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat'    => 'required|string|max:255',
            'pengirim'       => 'required|string|max:255',
            'perihal'        => 'required|string|max:255',
            'tanggal_surat'  => 'required|date',
            'keterangan'     => 'nullable|string',
            'file_surat'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Upload file
        if ($request->hasFile('file_surat')) {
            $validated['file_surat'] = $request->file('file_surat')
                ->store('surat-masuk', 'public');
        }

        SuratMasuk::create($validated);

        return redirect()
            ->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratMasuk $suratMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratMasuk $suratMasuk)
    {
        return view('surat-masuk.edit', [
            'title' => 'Edit Surat Masuk',
            'surat' => $suratMasuk
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validated = $request->validate([
            'nomor_surat'    => 'required|string|max:255',
            'pengirim'       => 'required|string|max:255',
            'perihal'        => 'required|string|max:255',
            'tanggal_surat'  => 'required|date',
            'keterangan'     => 'nullable|string',
            'file_surat'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Upload file baru (hapus lama)
        if ($request->hasFile('file_surat')) {
            if ($suratMasuk->file_surat) {
                Storage::disk('public')->delete($suratMasuk->file_surat);
            }

            $validated['file_surat'] = $request->file('file_surat')
                ->store('surat-masuk', 'public');
        }

        $suratMasuk->update($validated);

        return redirect()
            ->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratMasuk $suratMasuk)
    {
        if ($suratMasuk->file_surat) {
            Storage::disk('public')->delete($suratMasuk->file_surat);
        }

        $suratMasuk->delete();

        return redirect()
            ->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil dihapus.');
    }
}
