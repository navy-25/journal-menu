<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $menu   = ['choco strawberry', 'choco vanilla', 'choco greentea', 'choco mix', 'choco cheese', 'choco oreo', 'sosis', 'sosis keju', 'sosis mozzarella', 'super mozzarella komplit', 'special ayam mozzarella', 'smoke beef mozzarella', 'meat lovers', 'papperoni mozzarella',];
        $hpp    = [6300, 6300, 6300, 6465, 7800, 7700, 6600, 8100, 9100, 9390, 11200, 10800, 10800, 10800,];
        $price  = [10000, 10000, 10000, 11000, 15000, 15000, 10000, 15000, 15000, 15000, 20000, 18000, 18000, 18000,];
        foreach ($menu as $key => $value) {
            Menu::create([
                'name'  => $value,
                'price' => $price[$key],
                'hpp' => $hpp[$key],
            ]);
        }

        $this->call([
            StockSeeder::class,
            UserSeeder::class,
        ]);
    }
}
