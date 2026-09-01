<?php

namespace App\Policies;

use App\Models\Empresa;
use App\Models\User;

class EmpresaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('empresas.ver');
    }

    public function view(User $user, Empresa $empresa): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        return $user->can('empresas.ver') && $user->empresa_id === $empresa->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    public function update(User $user, Empresa $empresa): bool
    {
        return $user->hasRole('super_admin');
    }

    public function delete(User $user, Empresa $empresa): bool
    {
        return $user->hasRole('super_admin');
    }
}
