<?php

namespace App\Policies;

use App\Models\Sucursal;
use App\Models\User;

class SucursalPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('sucursales.ver');
    }

    public function view(User $user, Sucursal $sucursal): bool
    {
        return $this->esDeSuEmpresa($user, $sucursal) && $user->can('sucursales.ver');
    }

    public function create(User $user): bool
    {
        return $user->can('sucursales.crear');
    }

    public function update(User $user, Sucursal $sucursal): bool
    {
        return $this->esDeSuEmpresa($user, $sucursal) && $user->can('sucursales.editar');
    }

    public function delete(User $user, Sucursal $sucursal): bool
    {
        return $this->esDeSuEmpresa($user, $sucursal) && $user->can('sucursales.eliminar');
    }

    private function esDeSuEmpresa(User $user, Sucursal $sucursal): bool
    {
        return $user->hasRole('super_admin') || $user->empresa_id === $sucursal->empresa_id;
    }
}
