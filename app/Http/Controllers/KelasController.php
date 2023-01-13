<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{

    public function index()
    {
        $data_kelas = Kelas::all();

        return view('kelas.index', compact('data_kelas'));
    }

    public function tambah()
    {
        return view('kelas.create');
    }

    public function proses_tambah(Request $request)
    {

        // Aturan Validasi
        $rule_validasi = [
            'nama_kelas'  => 'required|min:3',
            'waktu'       => 'required|min:3',
        ];

        // Custom Message
        $pesan_validasi = [
            'nama_kelas.required'        => 'Nama kelas Harus di Isi !',
            'nama_kelas.min'             => 'Nama Kelas Minimal 3 Karakter !',

            'waktu.required'        => 'waktu Harus di Isi !',
            'waktu.min'             => 'waktu Minimal 3 Karakter !',
        ];

        // Lakukan Validasi
        $request->validate($rule_validasi, $pesan_validasi);

        // Mapping All Request 
        $data_to_save               = new Kelas();
        $data_to_save->nama_kelas   = $request->nama_kelas;
        $data_to_save->waktu       = $request->waktu;

        // Save to DB
        $data_to_save->save();

        // Kembali dengan Flash Session Data
        return back()->with('status', 'Data Telah Disimpan !');
    }

    public function detail($id)
    {
        $detail_kelas = Kelas::findOrFail($id);

        return view('kelas.detail', compact('detail_kelas'));
    }

    public function hapus($id)
    {
        $detail_kelas = kelas::findOrFail($id);

        if ($detail_kelas->mahasiswa()->exists()) {
            return back()->with('status', 'Tidak dapat hapus data ber-relasi !');
        }
        
        $detail_kelas->delete();

        return back()->with('status', 'Data Berhasil di Hapus !');
    }

    public function ubah($id)
    {
        $detail_kelas = kelas::findOrFail($id);

        return view('kelas.edit', compact('detail_kelas'));
    }

    public function proses_ubah(Request $request, $id)
    {

        // Aturan Validasi
        $rule_validasi = [
            'nama_kelas'  => 'required|min:3',
            'waktu'       => 'required|min:3',
        ];

        // Custom Message
        $pesan_validasi = [
            'nama_kelas.required'        => 'Nama Kelas Harus di Isi !',
            'nama_kelas.min'             => 'Nama Kelas Minimal 3 Karakter !',

            'waktu.required'        => 'waktu Harus di Isi !',
            'waktu.min'             => 'waktu Minimal 3 Karakter !',
        ];

        // Lakukan Validasi
        $request->validate($rule_validasi, $pesan_validasi);

        // Mapping All Request 
        $data_to_save               = Kelas::findOrFail($id);
        $data_to_save->nama_kelas   = $request->nama_kelas;
        $data_to_save->waktu       = $request->waktu;

        // Save to DB
        $data_to_save->save();

        // Kembali dengan Flash Session Data
        return back()->with('status', 'Data Telah Disimpan !');
    }

}