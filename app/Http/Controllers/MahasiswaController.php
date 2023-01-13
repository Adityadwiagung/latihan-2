<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Mahasiswa;
use App\Models\Kelas;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {

        // Variable Pencarian
        $cari_nama = $request->cari_nama;
        $cari_nama_kelas = $request->cari_nama_kelas;

        $tipe_sort = 'desc';
        $var_sort = 'created_at';

        // Prepare Model
        $data_mahasiswa = Mahasiswa::query();

        // Kondisi Pencarian
        if ($request->filled('cari_nama')) {
            $data_mahasiswa = $data_mahasiswa->where('nama', 'LIKE', '%' . $cari_nama . '%');
        }

        if ($request->filled('cari_nama_kelas')) {
            $data_mahasiswa = $data_mahasiswa->whereHas('kelas', function (Builder $query) use ($cari_nama_kelas) {
                $query->where('nama', 'LIKE', '%' . $cari_nama_kelas . '%');
            });
        }

        // Kondisi Sorting
        if( $request->has('tipe_sort') || $request->has('var_sort') ) {
            $tipe_sort = $request->tipe_sort;
            $var_sort = $request->var_sort;

            $data_mahasiswa = $data_mahasiswa->orderBy($var_sort, $tipe_sort);
        }

        // Kondisi Paginate

        $set_pagination = $request->set_pagination;

        if ($request->filled('set_pagination')) {
            $data_mahasiswa = $data_mahasiswa
                        ->orderBy($var_sort, $tipe_sort)
                        ->paginate($set_pagination);
        } else {
            $data_mahasiswa = $data_mahasiswa
                        ->orderBy($var_sort, $tipe_sort)
                        ->paginate(5);
        }

        // Append Query String to Pagination
        $data_mahasiswa = $data_mahasiswa->withQueryString();


        // Return View dengan Data
        return view('mahasiswa.index', compact(
            'data_mahasiswa',
            'cari_nama',
            'cari_nama_kelas',
        
            'tipe_sort',
            'var_sort',

            'set_pagination'
        ));

        
    }

    public function tambah()
    {
        $data_kelas = Kelas::all();

        return view('mahasiswa.create', compact('data_kelas'));
    }


    public function proses_tambah(Request $request)
    {

        // Aturan Validasi
        $rule_validasi = [
            'nama'         => 'required|min:3',
            'nim'      => 'required|numeric',
            'kelas_ke'   => 'required',
        ];

        // Custom Message
        $pesan_validasi = [
            'nama.required'        => 'Nama Harus di Isi !',
            'nama.min'             => 'Nama Minimal 3 Karakter !',

            'nim.required'     => 'Nim Harus di Isi',
            'nim.numeric'      => 'Nim Harus Berupa Angka',
            'kelas_ke.required'     => 'Kelas Harus di Isi',
            
        ];

        // Lakukan Validasi
        $request->validate($rule_validasi, $pesan_validasi);

        // Mapping All Request 
        $data_to_save               = new Mahasiswa();
        $data_to_save->nama         = $request->nama;
        $data_to_save->nim          = $request->nim;
        $data_to_save->kelas_id     = $request->kelas_ke;

        // Save to DB
        $data_to_save->save();

        // Kembali dengan Flash Session Data
        return back()->with('status', 'Data Telah Disimpan !');
    }

    public function detail($id)
    {
        $detail_mahasiswa = Mahasiswa::findOrFail($id);

        return view('mahasiswa.detail', compact('detail_mahasiswa'));
    }

    public function hapus($id)
    {
        $detail_mahasiswa = Mahasiswa::findOrFail($id);

        $detail_mahasiswa->delete();

        return back()->with('status', 'Data Berhasil di Hapus !');
    }

    public function ubah($id)
    {
        $detail_mahasiswa = Mahasiswa::findOrFail($id);
        $data_kelas = Kelas::all();

        return view('mahasiswa.edit', compact('detail_mahasiswa', 'data_kelas'));
    }

    public function proses_ubah(Request $request, $id)
    {

        // Aturan Validasi
        $rule_validasi = [
            'nama'          => 'required|min:3',
            'nim'           => 'required|numeric',
            'kelas_ke'      => 'required',
        ];

        // Custom Message
        $pesan_validasi = [
            'nama.required'        => 'Nama Harus di Isi !',
            'nama.min'             => 'Nama Minimal 3 Karakter !',

            'nim.required'          => 'nim Harus di Isi',
            'nim.numeric'           => 'nim Harus Berupa Angka',
            'kelas_ke.required'     => 'Kelas Harus di Isi',
        ];

        // Lakukan Validasi
        $request->validate($rule_validasi, $pesan_validasi);

        // Mapping All Request 
        $data_to_save               = Mahasiswa::findOrFail($id);
        $data_to_save->nama         = $request->nama;
        $data_to_save->nim          = $request->nim;
        $data_to_save->kelas_id     = $request->kelas_ke;

        // Save to DB
        $data_to_save->save();

        // Kembali dengan Flash Session Data
        return back()->with('status', 'Update Data Berhasil !');
    }

}