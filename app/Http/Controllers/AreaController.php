<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Area::class, 'area');
    }

    public function index(Request $request)
    {
        $areas = Area::query()
            ->with(['sucursal', 'encargado'])
            ->when(! auth()->user()->hasRole('super_admin'), fn ($q) => $q->whereHas('sucursal', fn ($q2) => $q2->where('empresa_id', auth()->user()->empresa_id)))
            ->when($request->buscar, fn ($q) => $q->where('nombre', 'like', "%{$request->buscar}%"))
            ->orderBy('nombre')
            ->paginate(10);

        return view('areas.index', ['areas' => $areas]);
    }

    public function create()
    {
        return view('areas.create', [
            'sucursales' => $this->sucursalesDisponibles(),
            'usuarios' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sucursal_id' => 'required|exists:sucursales,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'encargado_id' => 'nullable|exists:users,id',
            'estado' => 'required|in:activo,inactivo',
        ]);

        Area::create($data);

        return redirect()->route('areas.index')->with('exito', 'Area creada correctamente.');
    }

    public function edit(Area $area)
    {
        return view('areas.edit', [
            'area' => $area,
            'sucursales' => $this->sucursalesDisponibles(),
            'usuarios' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Area $area)
    {
        $data = $request->validate([
            'sucursal_id' => 'required|exists:sucursales,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'encargado_id' => 'nullable|exists:users,id',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $area->update($data);

        return redirect()->route('areas.index')->with('exito', 'Area actualizada correctamente.');
    }

    public function destroy(Area $area)
    {
        if ($area->inventario()->where('cantidad', '>', 0)->exists()) {
            return back()->with('error', 'No se puede eliminar el area porque tiene stock activo.');
        }

        $area->delete();

        return redirect()->route('areas.index')->with('exito', 'Area eliminada correctamente.');
    }

    private function sucursalesDisponibles()
    {
        return Sucursal::query()
            ->when(! auth()->user()->hasRole('super_admin'), fn ($q) => $q->where('empresa_id', auth()->user()->empresa_id))
            ->orderBy('nombre')
            ->get();
    }
}
