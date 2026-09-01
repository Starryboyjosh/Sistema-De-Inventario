<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $proveedores = Proveedor::query()
            ->where('empresa_id', auth()->user()->empresa_id)
            ->when($request->buscar, fn ($q) => $q->where('nombre', 'like', "%{$request->buscar}%"))
            ->orderBy('nombre')
            ->paginate(10);

        return view('proveedores.index', ['proveedores' => $proveedores]);
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'contacto' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:30',
            'correo' => 'nullable|email|max:255',
        ]);

        $data['empresa_id'] = auth()->user()->empresa_id;

        Proveedor::create($data);

        return redirect()->route('proveedores.index')->with('exito', 'Proveedor creado correctamente.');
    }

    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', ['proveedor' => $proveedor]);
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'contacto' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:30',
            'correo' => 'nullable|email|max:255',
        ]);

        $proveedor->update($data);

        return redirect()->route('proveedores.index')->with('exito', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('exito', 'Proveedor eliminado correctamente.');
    }
}
