<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventarioArea extends Model
{
    protected $table = 'inventario_area';

    protected $fillable = ['item_id', 'area_id', 'cantidad'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
}
