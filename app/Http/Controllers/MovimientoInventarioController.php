<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrasladoRequest;
use App\Models\Area;
use App\Models\InventarioArea;
use App\Models\Item;
use App\Models\MovimientoInventario;
use App\Services\InventarioService;
use Illuminate\Http\Request;
use Exception;

class MovimientoInventarioController extends Controller
{
    public function __construct(private InventarioService $inventarioService)
    {
    }

    public function index(Request $request)
    {
        $empresaId = auth()->user()->empresa_id;

        $movimientos = MovimientoInventario::query()
            ->with(['item', 'areaOrigen', 'areaDestino', 'usuario'])
            ->whereHas('item', fn ($q) => $q->where('empresa_id', $empresaId))
            ->when($request->tipo, fn ($q) => $q->where('tipo', $request->tipo))
            ->when($request->item_id, fn ($q) => $q->where('item_id', $request->item_id))
            ->latest()
            ->paginate(15);

        return view('movimientos.index', [
            'movimientos' => $movimientos,
            'items' => Item::where('empresa_id', $empresaId)->orderBy('nombre')->get(),
        ]);
    }

    public function entrada()
    {
        return view('movimientos.entrada', $this->datosFormulario());
    }

    public function guardarEntrada(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'area_id' => 'required|exists:areas,id',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string|max:255',
        ]);

        $item = Item::findOrFail($data['item_id']);
        $this->inventarioService->entrada($item, $data['area_id'], $data['cantidad'], $data['motivo'] ?? null);

        return redirect()->route('movimientos.index')->with('exito', 'Entrada registrada correctamente.');
    }

    public function salida()
    {
        return view('movimientos.salida', $this->datosFormulario());
    }

    public function guardarSalida(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'area_id' => 'required|exists:areas,id',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string|max:255',
        ]);

        $item = Item::findOrFail($data['item_id']);

        try {
            $this->inventarioService->salida($item, $data['area_id'], $data['cantidad'], $data['motivo'] ?? null);
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('movimientos.index')->with('exito', 'Salida registrada correctamente.');
    }

    public function traslado()
    {
        return view('movimientos.traslado', $this->datosFormulario());
    }

    public function guardarTraslado(StoreTrasladoRequest $request)
    {
        $data = $request->validated();
        $item = Item::findOrFail($data['item_id']);

        try {
            $this->inventarioService->traslado($item, $data['area_origen_id'], $data['area_destino_id'], $data['cantidad'], $data['motivo'] ?? null);
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('movimientos.index')->with('exito', 'Traslado registrado correctamente.');
    }

    public function ajuste()
    {
        return view('movimientos.ajuste', $this->datosFormulario());
    }

    public function guardarAjuste(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'area_id' => 'required|exists:areas,id',
            'cantidad' => 'required|integer|min:0',
            'motivo' => 'required|string|max:255',
        ]);

        $item = Item::findOrFail($data['item_id']);

        try {
            $this->inventarioService->ajuste($item, $data['area_id'], $data['cantidad'], $data['motivo']);
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('movimientos.index')->with('exito', 'Ajuste registrado correctamente.');
    }

    public function stockPorArea(Request $request, int $areaId)
    {
        $stock = InventarioArea::where('area_id', $areaId)->pluck('cantidad', 'item_id');

        return response()->json($stock);
    }

    private function datosFormulario(): array
    {
        $empresaId = auth()->user()->empresa_id;

        return [
            'items' => Item::where('empresa_id', $empresaId)->orderBy('nombre')->get(),
            'areas' => Area::whereHas('sucursal', fn ($q) => $q->where('empresa_id', $empresaId))->orderBy('nombre')->get(),
        ];
    }
}
