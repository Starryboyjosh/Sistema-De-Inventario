<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'empresa_id',
        'categoria_id',
        'unidad_medida_id',
        'proveedor_id',
        'nombre',
        'sku',
        'descripcion',
        'imagen',
        'costo_unitario',
        'stock_minimo',
        'estado',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function unidadMedida(): BelongsTo
    {
        return $this->belongsTo(UnidadMedida::class);
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function inventario(): HasMany
    {
        return $this->hasMany(InventarioArea::class);
    }

    public function stockTotal(): int
    {
        return $this->inventario()->sum('cantidad');
    }
}
