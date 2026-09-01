<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Models\Categoria;
use App\Models\Item;
use App\Models\Proveedor;
use App\Models\UnidadMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Item::class, 'item');
    }

    public function index(Request $request)
    {
        $items = Item::query()
            ->with(['categoria', 'unidadMedida'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->when($request->buscar, fn ($q) => $q->where('nombre', 'like', "%{$request->buscar}%")->orWhere('sku', 'like', "%{$request->buscar}%"))
            ->when($request->categoria_id, fn ($q) => $q->where('categoria_id', $request->categoria_id))
            ->orderBy('nombre')
            ->paginate(10);

        return view('items.index', [
            'items' => $items,
            'categorias' => Categoria::where('empresa_id', auth()->user()->empresa_id)->orderBy('nombre')->get(),
        ]);
    }

    public function create()
    {
        return view('items.create', $this->datosFormulario());
    }

    public function store(StoreItemRequest $request)
    {
        $data = $request->validated();
        $data['empresa_id'] = auth()->user()->empresa_id;
        $data['sku'] = $data['sku'] ?: $this->generarSku();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('items', 'public');
        }

        Item::create($data);

        return redirect()->route('items.index')->with('exito', 'Item creado correctamente.');
    }

    public function show(Item $item)
    {
        $item->load(['inventario.area.sucursal']);

        return view('items.show', ['item' => $item]);
    }

    public function edit(Item $item)
    {
        return view('items.edit', array_merge(['item' => $item], $this->datosFormulario()));
    }

    public function update(StoreItemRequest $request, Item $item)
    {
        $data = $request->validated();
        $data['sku'] = $data['sku'] ?: $item->sku;

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('items', 'public');
        }

        $item->update($data);

        return redirect()->route('items.index')->with('exito', 'Item actualizado correctamente.');
    }

    public function destroy(Item $item)
    {
        if ($item->stockTotal() > 0) {
            return back()->with('error', 'No se puede eliminar el item porque tiene stock activo.');
        }

        $item->delete();

        return redirect()->route('items.index')->with('exito', 'Item eliminado correctamente.');
    }

    private function datosFormulario(): array
    {
        $empresaId = auth()->user()->empresa_id;

        return [
            'categorias' => Categoria::where('empresa_id', $empresaId)->orderBy('nombre')->get(),
            'unidades' => UnidadMedida::orderBy('nombre')->get(),
            'proveedores' => Proveedor::where('empresa_id', $empresaId)->orderBy('nombre')->get(),
        ];
    }

    private function generarSku(): string
    {
        return 'SKU-'.strtoupper(Str::random(8));
    }
}
