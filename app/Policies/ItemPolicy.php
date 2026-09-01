<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;

class ItemPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('items.ver');
    }

    public function view(User $user, Item $item): bool
    {
        return $this->esDeSuEmpresa($user, $item) && $user->can('items.ver');
    }

    public function create(User $user): bool
    {
        return $user->can('items.crear');
    }

    public function update(User $user, Item $item): bool
    {
        return $this->esDeSuEmpresa($user, $item) && $user->can('items.editar');
    }

    public function delete(User $user, Item $item): bool
    {
        return $this->esDeSuEmpresa($user, $item) && $user->can('items.eliminar');
    }

    private function esDeSuEmpresa(User $user, Item $item): bool
    {
        return $user->hasRole('super_admin') || $user->empresa_id === $item->empresa_id;
    }
}
