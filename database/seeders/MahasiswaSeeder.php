<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mahasiswa')->insert([
            [
                'nama'         => 'Agung',
                'nim'          => 8020200271,
                'kelas_id'     => 1,
                'created_at'   => date("Y-m-d H:i:s")
            ],
            [
                'nama'         => 'Doni',
                'nim'          => 8020200272,
                'kelas_id'     => 2,
                'created_at'    => date("Y-m-d H:i:s")
            ]
        ]);
    }
}
