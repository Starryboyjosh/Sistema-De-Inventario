<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 4px; text-align: left; }
    </style>
</head>
<body>
    <h2>Reporte de inventario</h2>
    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Stock total</th>
                <th>Stock minimo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->sku }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->categoria->nombre ?? '-' }}</td>
                    <td>{{ $item->stockTotal() }}</td>
                    <td>{{ $item->stock_minimo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
