<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sucursal_id',
        'nombre',
        'descripcion',
        'encargado_id',
        'estado',
    ];

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function encargado(): BelongsTo
    {
        return $this->belongsTo(User::class, 'encargado_id');
    }

    public function inventario(): HasMany
    {
        return $this->hasMany(InventarioArea::class);
    }
}
