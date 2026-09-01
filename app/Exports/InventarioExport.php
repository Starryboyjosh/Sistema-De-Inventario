<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventarioExport implements FromCollection, WithHeadings
{
    public function __construct(private int $empresaId)
    {
    }

    public function collection()
    {
        return Item::where('empresa_id', $this->empresaId)
            ->with(['categoria', 'unidadMedida'])
            ->get()
            ->map(fn ($item) => [
                'sku' => $item->sku,
                'nombre' => $item->nombre,
                'categoria' => $item->categoria->nombre ?? '-',
                'unidad' => $item->unidadMedida->nombre ?? '-',
                'stock_total' => $item->stockTotal(),
                'stock_minimo' => $item->stock_minimo,
                'estado' => $item->estado,
            ]);
    }

    public function headings(): array
    {
        return ['SKU', 'Nombre', 'Categoria', 'Unidad', 'Stock total', 'Stock minimo', 'Estado'];
    }
}
