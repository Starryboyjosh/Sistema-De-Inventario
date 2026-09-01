<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoInventario extends Model
{
    const UPDATED_AT = null;

    protected $table = 'movimientos_inventario';

    protected $fillable = [
        'item_id',
        'tipo',
        'cantidad',
        'area_origen_id',
        'area_destino_id',
        'usuario_id',
        'motivo',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function areaOrigen(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_origen_id');
    }

    public function areaDestino(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_destino_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
