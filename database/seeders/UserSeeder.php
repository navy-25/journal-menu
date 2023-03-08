<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Stock;
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
            'name'      => 'Developer',
            'phone'     => '250199',
            'role'      => 0,
            'owner'     => 'developer',
            'status'    => 1,
            'address'   => 'Unknown',
            'email'     => 'developer@gmail.com',
            'password'  => Hash::make('123'),
        ]);

        $data = User::create([
            'name'      => 'Merchant Sidoarjo',
            'phone'     => '082132521665',
            'role'      => 2,
            'owner'     => 'Nafi & Dani',
            'status'    => 1,
            'address'   => 'Depan Candi Mitra Jaya Auto Car Wash, Jl. Maritim, Balonggabus, Kec. Candi, Kabupaten Sidoarjo, Jawa Timur 61271',
            'email'     => 'nafimaulahakim123@gmail.com',
            'password'  => Hash::make('123'),
        ]);

        $menu   = ['choco strawberry', 'choco vanilla', 'choco greentea', 'choco mix', 'choco cheese', 'choco oreo', 'sosis', 'sosis keju', 'sosis mozzarella', 'super mozzarella komplit', 'special ayam mozzarella', 'smoke beef mozzarella', 'meat lovers', 'papperoni mozzarella',];
        $hpp    = [6300, 6300, 6300, 6465, 7800, 7700, 6600, 8100, 9100, 9390, 11200, 10800, 10800, 10800,];
        $price  = [10000, 10000, 10000, 11000, 15000, 15000, 10000, 15000, 15000, 15000, 20000, 18000, 18000, 18000,];
        foreach ($menu as $key => $value) {
            Menu::create([
                'name'      => $value,
                'price'     => $price[$key],
                'hpp'       => $hpp[$key],
                'id_user'   => $data->id,
            ]);
        }
        $name = [
            'Roti',
            // 'Saus Pasta',
            // 'Sosis',
            // 'Papperoni',
            // 'Beef',
            // 'Oreo',
            // 'Glaze Coklat',
            // 'Glaze Strawberry',
            // 'Glaze Vanilla',
            // 'Glaze Greentea',
            // 'Meses',
            // 'Keju',
            // 'Saus Keju',
            // 'Mozarella',
            // 'Saus Tomat',
            // 'Saus Pedas',
            // 'Mayonise',
            // 'Margarin',
            // 'Saus Sachetan',
            'Kotak Pizza',
        ];

        foreach ($name as $key => $value) {
            Stock::create([
                'id'        => ++$key,
                'name'      => $value,
                'qty'       => 0,
                'unit'      => '',
                'qty_usage' => 0,
                'id_user'   => $data->id,
            ]);
        }
    }
}
