<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();

        // for ($i = 1; $i <= 10; $i++) {

        //     // insert data ke table pegawai menggunakan Faker
        //     DB::table('disposisi')->insert([
        //         'nip' => null,
        //         'no_agenda' => $i,
        //         'id_status' => 1,
        //         'keterangan' => 'Surat Masuk'
        //     ]);
        // }
    }
}
