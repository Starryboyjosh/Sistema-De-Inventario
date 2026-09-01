<?php

namespace App\Http\Controllers;

use App\Exports\InventarioExport;
use App\Models\Item;
use App\Models\MovimientoInventario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    public function inventario(Request $request)
    {
        $empresaId = auth()->user()->empresa_id;

        $items = Item::where('empresa_id', $empresaId)
            ->with(['categoria', 'unidadMedida'])
            ->when($request->categoria_id, fn ($q) => $q->where('categoria_id', $request->categoria_id))
            ->orderBy('nombre')
            ->get();

        return view('reportes.inventario', ['items' => $items]);
    }

    public function exportarInventarioExcel()
    {
        $empresaId = auth()->user()->empresa_id;

        return Excel::download(new InventarioExport($empresaId), 'inventario.xlsx');
    }

    public function exportarInventarioPdf()
    {
        $empresaId = auth()->user()->empresa_id;
        $items = Item::where('empresa_id', $empresaId)->with(['categoria', 'unidadMedida'])->orderBy('nombre')->get();

        $pdf = Pdf::loadView('reportes.inventario-pdf', ['items' => $items]);

        return $pdf->download('inventario.pdf');
    }

    public function movimientos(Request $request)
    {
        $empresaId = auth()->user()->empresa_id;

        $movimientos = MovimientoInventario::with(['item', 'areaOrigen', 'areaDestino', 'usuario'])
            ->whereHas('item', fn ($q) => $q->where('empresa_id', $empresaId))
            ->when($request->tipo, fn ($q) => $q->where('tipo', $request->tipo))
            ->when($request->desde, fn ($q) => $q->whereDate('created_at', '>=', $request->desde))
            ->when($request->hasta, fn ($q) => $q->whereDate('created_at', '<=', $request->hasta))
            ->latest()
            ->paginate(20);

        return view('reportes.movimientos', ['movimientos' => $movimientos]);
    }
}
