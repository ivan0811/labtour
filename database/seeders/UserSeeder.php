<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'id' => 1,
                'name' => 'Argya AF',
                'username' => 'Argya',
                'email' => 'ardian20146@gmail.com',
                'password' => Hash::make('12345678')
            ],
            [
                'id' => 2,
                'name' => 'Ivan F',
                'username' => 'Ivan',
                'email' => 'ivanfaathirza@gmail.com',
                'password' => Hash::make('12345678')
            ],
            [
                'id' => 3,
                'name' => 'Firman Sahita',
                'username' => 'Firman',
                'email' => 'firman.10119002@mahasiswa.unikom.ac.id',
                'password' => Hash::make('12345678')
            ],
            [
                'id' => 4,
                'name' => 'Muhammad Khatami',
                'username' => 'Tommy',
                'email' => 'khatami.10119026@mahasiswa.unikom.ac.id',
                'password' => Hash::make('12345678')
            ],
            [
                'id' => 5,
                'name' => 'Ginanjar Tubagus Gumilar',
                'username' => 'Ginanjar',
                'email' => 'ginanjar.10119032@mahasiswa.unikom.ac.id',
                'password' => Hash::make('12345678')
            ],
        ]);
    }
}
