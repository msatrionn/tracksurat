<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        // $users = [
            // ['name' => 'Admin', 'email' => 'admin@gmail.com', 'level' => 'admin', 'password' => bcrypt('1234')],
            // ['name' => 'Tata Usaha', 'email' => 'tata_usaha@gmail.com', 'level' => 'tata_usaha', 'password' => bcrypt('1234')],
            // ['name' => 'Kepala Sekolah',  'email' => 'kepsek@gmail.com', 'level' => 'kepala_sekolah', 'password' => bcrypt('1234')],
            // ['name' => 'Waka Kurikulum',  'email' => 'waka_kurikulum@gmail.com', 'level' => 'disposisi', 'password' => bcrypt('1234')],
            // ['name' => 'Waka Siswa',  'email' => 'waka_siswa@gmail.com', 'level' => 'disposisi', 'password' => bcrypt('1234')],
            // ['name' => 'Waka Humas',  'email' => 'waka_humas@gmail.com', 'level' => 'disposisi', 'password' => bcrypt('1234')],
            // ['name' => 'Waka Sarana',  'email' => 'waka_sarana@gmail.com', 'level' => 'disposisi', 'password' => bcrypt('1234')],
            // ['name' => 'Koordinator BK',  'email' => 'koordinator_bk@gmail.com', 'level' => 'disposisi', 'password' => bcrypt('1234')],
            // ['name' => 'Kepala Perpustakaan',  'email' => 'kepala_perpus@gmail.com', 'level' => 'disposisi', 'password' => bcrypt('1234')],
            // ['name' => 'Guru Mapel',  'email' => 'guru_mapel@gmail.com', 'level' => 'disposisi', 'password' => bcrypt('1234')],
        // ];
        // foreach ($users as $key => $value) {
        //     return $value;
        // }
        return [
            'name' => 'kasubag',
            'email' => 'kasubag@gmail.com',
            'level' => 'kasubag',
            'email_verified_at' => now(),
            'password' => bcrypt('1234'), // password
            'remember_token' => Str::random(10),
        ];
    }
    // ,
    // }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
