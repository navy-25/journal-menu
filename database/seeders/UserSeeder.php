<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Merchant Sidoarjo',
            'phone'     => '082132521665',
            'role'      => 2,
            'owner'     => 'Nafi & Dani',
            'status'    => 1,
            'address'   => 'Depan Candi Mitra Jaya Auto Car Wash, Jl. Maritim, Balonggabus, Kec. Candi, Kabupaten Sidoarjo, Jawa Timur 61271',
            'email'     => 'nafimaulahakim123@gmail.com',
            'password'  => Hash::make('123'),
        ]);
        User::create([
            'name'      => 'Developer',
            'phone'     => '250199',
            'role'      => 0,
            'owner'     => 'developer',
            'status'    => 1,
            'address'   => 'Unknown',
            'email'     => 'developer@gmail.com',
            'password'  => Hash::make('123'),
        ]);
    }
}
