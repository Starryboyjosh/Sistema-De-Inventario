<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Empresa::class, 'empresa');
    }

    public function index(Request $request)
    {
        $empresas = Empresa::query()
            ->when($request->buscar, fn ($q) => $q->where('nombre', 'like', "%{$request->buscar}%"))
            ->orderBy('nombre')
            ->paginate(10);

        return view('empresas.index', ['empresas' => $empresas]);
    }

    public function create()
    {
        return view('empresas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'identificacion_fiscal' => 'required|string|max:50|unique:empresas',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:30',
            'correo' => 'nullable|email|max:255',
            'estado' => 'required|in:activo,inactivo',
        ]);

        Empresa::create($data);

        return redirect()->route('empresas.index')->with('exito', 'Empresa creada correctamente.');
    }

    public function edit(Empresa $empresa)
    {
        return view('empresas.edit', ['empresa' => $empresa]);
    }

    public function update(Request $request, Empresa $empresa)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'identificacion_fiscal' => 'required|string|max:50|unique:empresas,identificacion_fiscal,'.$empresa->id,
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:30',
            'correo' => 'nullable|email|max:255',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $empresa->update($data);

        return redirect()->route('empresas.index')->with('exito', 'Empresa actualizada correctamente.');
    }

    public function destroy(Empresa $empresa)
    {
        if ($empresa->sucursales()->exists()) {
            return back()->with('error', 'No se puede eliminar la empresa porque tiene sucursales activas.');
        }

        $empresa->delete();

        return redirect()->route('empresas.index')->with('exito', 'Empresa eliminada correctamente.');
    }
}
