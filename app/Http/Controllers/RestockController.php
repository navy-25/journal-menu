<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class RestockController extends Controller
{
    public function index(Request $request)
    {
        $page = 'Restock';
        $material = Material::orderBy('name', 'ASC')->where('id_user', getUserID())->get();

        $calculate = [
            'total_bahan' => $request->get('total_bahan', 0),
            'total_pengiriman' => $request->get('total_pengiriman', 60000),
            'grand_total' => $request->get('grand_total', 0),
        ];

        $checkpoint = [
            'material_id' => $request->query('material_id', []),
            'qty' => $request->query('qty', []),
        ];

        // dd($checkpoint);

        return view('restock', compact('page', 'material', 'calculate', 'checkpoint'));
    }

    public function calculate(Request $request)
    {
        $materialIds = $request->input('material_id', []);
        $quantities = $request->input('qty', []);

        $total_bahan = 0;

        foreach ($materialIds as $index => $id) {
            $qty = (int) $quantities[$index];

            if ($qty > 0) {
                $material = Material::find($id);
                if ($material) {
                    $total_bahan += $material->price * $qty;
                }
            }
        }

        $total_pengiriman = 60000;
        $grand_total = $total_bahan + $total_pengiriman;

        return redirect()->route('restock.index', [
            'total_bahan' => $total_bahan,
            'total_pengiriman' => $total_pengiriman,
            'grand_total' => $grand_total,
            'material_id' => $materialIds,
            'qty' => $quantities,
        ]);
    }
}
