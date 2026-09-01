<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Sucursal::class, 'sucursal');
    }

    public function index(Request $request)
    {
        $sucursales = Sucursal::query()
            ->with('empresa')
            ->when(! auth()->user()->hasRole('super_admin'), fn ($q) => $q->where('empresa_id', auth()->user()->empresa_id))
            ->when($request->buscar, fn ($q) => $q->where('nombre', 'like', "%{$request->buscar}%"))
            ->orderBy('nombre')
            ->paginate(10);

        return view('sucursales.index', ['sucursales' => $sucursales]);
    }

    public function create()
    {
        $empresas = Empresa::orderBy('nombre')->get();

        return view('sucursales.create', ['empresas' => $empresas]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:30',
            'estado' => 'required|in:activo,inactivo',
        ]);

        if (! auth()->user()->hasRole('super_admin')) {
            $data['empresa_id'] = auth()->user()->empresa_id;
        }

        Sucursal::create($data);

        return redirect()->route('sucursales.index')->with('exito', 'Sucursal creada correctamente.');
    }

    public function edit(Sucursal $sucursal)
    {
        $empresas = Empresa::orderBy('nombre')->get();

        return view('sucursales.edit', ['sucursal' => $sucursal, 'empresas' => $empresas]);
    }

    public function update(Request $request, Sucursal $sucursal)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:30',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $sucursal->update($data);

        return redirect()->route('sucursales.index')->with('exito', 'Sucursal actualizada correctamente.');
    }

    public function destroy(Sucursal $sucursal)
    {
        if ($sucursal->areas()->exists()) {
            return back()->with('error', 'No se puede eliminar la sucursal porque tiene areas activas.');
        }

        $sucursal->delete();

        return redirect()->route('sucursales.index')->with('exito', 'Sucursal eliminada correctamente.');
    }
}
