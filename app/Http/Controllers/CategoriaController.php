<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::query()
            ->where('empresa_id', auth()->user()->empresa_id)
            ->when($request->buscar, fn ($q) => $q->where('nombre', 'like', "%{$request->buscar}%"))
            ->orderBy('nombre')
            ->paginate(10);

        return view('categorias.index', ['categorias' => $categorias]);
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $data['empresa_id'] = auth()->user()->empresa_id;

        Categoria::create($data);

        return redirect()->route('categorias.index')->with('exito', 'Categoria creada correctamente.');
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', ['categoria' => $categoria]);
    }

    public function update(Request $request, Categoria $categoria)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria->update($data);

        return redirect()->route('categorias.index')->with('exito', 'Categoria actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('categorias.index')->with('exito', 'Categoria eliminada correctamente.');
    }
}
