<?php

namespace App\Http\Controllers;

use App\Models\UnidadMedida;
use Illuminate\Http\Request;

class UnidadMedidaController extends Controller
{
    public function index()
    {
        $unidades = UnidadMedida::orderBy('nombre')->paginate(10);

        return view('unidades-medida.index', ['unidades' => $unidades]);
    }

    public function create()
    {
        return view('unidades-medida.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'abreviatura' => 'required|string|max:20',
        ]);

        UnidadMedida::create($data);

        return redirect()->route('unidades-medida.index')->with('exito', 'Unidad de medida creada correctamente.');
    }

    public function edit(UnidadMedida $unidad)
    {
        return view('unidades-medida.edit', ['unidad' => $unidad]);
    }

    public function update(Request $request, UnidadMedida $unidad)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'abreviatura' => 'required|string|max:20',
        ]);

        $unidad->update($data);

        return redirect()->route('unidades-medida.index')->with('exito', 'Unidad de medida actualizada correctamente.');
    }

    public function destroy(UnidadMedida $unidad)
    {
        $unidad->delete();

        return redirect()->route('unidades-medida.index')->with('exito', 'Unidad de medida eliminada correctamente.');
    }
}
