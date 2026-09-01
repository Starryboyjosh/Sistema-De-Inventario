<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MovimientoInventario;
use App\Models\Sucursal;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $empresaId = auth()->user()->empresa_id;

        $totalItems = Item::where('empresa_id', $empresaId)->count();

        $totalUnidades = DB::table('inventario_area')
            ->join('items', 'items.id', '=', 'inventario_area.item_id')
            ->where('items.empresa_id', $empresaId)
            ->sum('inventario_area.cantidad');

        $items = Item::where('empresa_id', $empresaId)->get();
        $alertas = $items->filter(fn ($item) => $item->stockTotal() <= $item->stock_minimo);

        $sucursales = Sucursal::where('empresa_id', $empresaId)->with('areas.inventario')->get();
        $porSucursal = $sucursales->map(function ($sucursal) {
            $total = 0;
            foreach ($sucursal->areas as $area) {
                $total += $area->inventario->sum('cantidad');
            }

            return ['nombre' => $sucursal->nombre, 'total' => $total];
        });

        $movimientos = MovimientoInventario::with(['item', 'usuario'])
            ->whereHas('item', fn ($q) => $q->where('empresa_id', $empresaId))
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard', [
            'totalItems' => $totalItems,
            'totalUnidades' => $totalUnidades,
            'alertas' => $alertas,
            'porSucursal' => $porSucursal,
            'movimientos' => $movimientos,
        ]);
    }
}
