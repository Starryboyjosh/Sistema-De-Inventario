<?php

namespace App\Services;

use App\Models\InventarioArea;
use App\Models\Item;
use App\Models\MovimientoInventario;
use Exception;

class InventarioService
{
    public function entrada(Item $item, int $areaId, int $cantidad, ?string $motivo = null): void
    {
        $inv = InventarioArea::firstOrNew(['item_id' => $item->id, 'area_id' => $areaId]);
        $inv->cantidad = $inv->cantidad + $cantidad;
        $inv->save();

        MovimientoInventario::create([
            'item_id' => $item->id,
            'tipo' => 'entrada',
            'cantidad' => $cantidad,
            'area_destino_id' => $areaId,
            'usuario_id' => auth()->id(),
            'motivo' => $motivo,
        ]);
    }

    public function salida(Item $item, int $areaId, int $cantidad, ?string $motivo = null): void
    {
        $inv = InventarioArea::where('item_id', $item->id)->where('area_id', $areaId)->first();

        if (! $inv || $inv->cantidad < $cantidad) {
            throw new Exception('No hay stock suficiente en el area para esta salida.');
        }

        $inv->cantidad = $inv->cantidad - $cantidad;
        $inv->save();

        MovimientoInventario::create([
            'item_id' => $item->id,
            'tipo' => 'salida',
            'cantidad' => $cantidad,
            'area_origen_id' => $areaId,
            'usuario_id' => auth()->id(),
            'motivo' => $motivo,
        ]);
    }

    public function traslado(Item $item, int $areaOrigenId, int $areaDestinoId, int $cantidad, ?string $motivo = null): void
    {
        $invOrigen = InventarioArea::where('item_id', $item->id)->where('area_id', $areaOrigenId)->first();

        if (! $invOrigen || $invOrigen->cantidad < $cantidad) {
            throw new Exception('No hay stock suficiente en el area de origen para el traslado.');
        }

        $invOrigen->cantidad = $invOrigen->cantidad - $cantidad;
        $invOrigen->save();

        $invDestino = InventarioArea::firstOrNew(['item_id' => $item->id, 'area_id' => $areaDestinoId]);
        $invDestino->cantidad = $invDestino->cantidad + $cantidad;
        $invDestino->save();

        MovimientoInventario::create([
            'item_id' => $item->id,
            'tipo' => 'traslado',
            'cantidad' => $cantidad,
            'area_origen_id' => $areaOrigenId,
            'area_destino_id' => $areaDestinoId,
            'usuario_id' => auth()->id(),
            'motivo' => $motivo,
        ]);
    }

    public function ajuste(Item $item, int $areaId, int $cantidadNueva, ?string $motivo = null): void
    {
        $inv = InventarioArea::firstOrNew(['item_id' => $item->id, 'area_id' => $areaId]);
        $diferencia = $cantidadNueva - $inv->cantidad;

        if ($cantidadNueva < 0) {
            throw new Exception('La cantidad ajustada no puede ser negativa.');
        }

        $inv->cantidad = $cantidadNueva;
        $inv->save();

        MovimientoInventario::create([
            'item_id' => $item->id,
            'tipo' => 'ajuste',
            'cantidad' => $diferencia,
            'area_destino_id' => $areaId,
            'usuario_id' => auth()->id(),
            'motivo' => $motivo,
        ]);
    }
}
