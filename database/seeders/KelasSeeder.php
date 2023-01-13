<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kelas')->insert([
            [
                'nama_kelas'   => '05PT5',
                'waktu'        => "Siang",
                'created_at'   => date("Y-m-d H:i:s")
            ],
            [
                'nama_kelas'   => '07MT5',
                'waktu'        => "Malam",
                'created_at'   => date("Y-m-d H:i:s")
            ],
        ]);
    }
}
