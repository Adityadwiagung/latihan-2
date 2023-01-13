<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $guarded = [];

    // Relasi ke Buku
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'kelas_id', 'id');
    }
}
