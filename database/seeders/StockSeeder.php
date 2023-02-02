<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stocks')->delete();
        
        $name = [
            'Roti',
            'Saus Pasta',
            'Sosis',
            'Papperoni',
            'Beef',
            'Oreo',
            'Glaze Coklat',
            'Glaze Strawberry',
            'Glaze Vanilla',
            'Glaze Greentea',
            'Meses',
            'Keju',
            'Saus Keju',
            'Mozarella',
            'Saus Tomat',
            'Saus Pedas',
            'Mayonise',
            'Margarin',
            'Saus Sachetan',
            'Kotak Pizza',
        ];

        foreach ($name as $key => $value) {
            Stock::create([
                'id'    => ++$key,
                'name'  => $value,
                'qty'   => 0,
                'unit'  => '',
                'qty_usage' => 0,
            ]);
        }
    }
}
