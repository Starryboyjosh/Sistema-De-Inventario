<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\InventarioArea;
use App\Models\Item;
use App\Models\MovimientoInventario;
use App\Models\Proveedor;
use App\Models\Sucursal;
use App\Models\UnidadMedida;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $empresa = Empresa::create([
            'nombre' => 'Ferreteria El Tornillo',
            'identificacion_fiscal' => '0801-1990-00001',
            'direccion' => 'Boulevard Morazan, Tegucigalpa',
            'telefono' => '2222-1111',
            'correo' => 'contacto@eltornillo.hn',
            'estado' => 'activo',
        ]);

        $admin = User::create([
            'name' => 'Admin Tornillo',
            'email' => 'admin@eltornillo.hn',
            'password' => bcrypt('password'),
            'empresa_id' => $empresa->id,
            'estado' => 'activo',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin_empresa');

        $unidades = [
            UnidadMedida::firstOrCreate(['nombre' => 'Unidad'], ['abreviatura' => 'und']),
            UnidadMedida::firstOrCreate(['nombre' => 'Caja'], ['abreviatura' => 'caja']),
            UnidadMedida::firstOrCreate(['nombre' => 'Kilogramo'], ['abreviatura' => 'kg']),
            UnidadMedida::firstOrCreate(['nombre' => 'Litro'], ['abreviatura' => 'lt']),
        ];

        $categorias = collect(['Herramientas', 'Tornilleria', 'Pintura', 'Electricidad'])->map(
            fn ($nombre) => Categoria::create(['empresa_id' => $empresa->id, 'nombre' => $nombre])
        );

        $proveedor = Proveedor::create([
            'empresa_id' => $empresa->id,
            'nombre' => 'Distribuidora Central',
            'contacto' => 'Carlos Reyes',
            'telefono' => '9999-8888',
            'correo' => 'ventas@distribuidoracentral.hn',
        ]);

        $sucursales = collect(['Sucursal Centro', 'Sucursal Comayaguela'])->map(
            fn ($nombre) => Sucursal::create([
                'empresa_id' => $empresa->id,
                'nombre' => $nombre,
                'direccion' => 'Direccion de '.$nombre,
                'telefono' => '2222-0000',
                'estado' => 'activo',
            ])
        );

        $nombresAreas = ['Bodega Principal', 'Exhibicion', 'Recepcion', 'Devoluciones'];
        $areas = collect();

        foreach ($sucursales as $sucursal) {
            foreach (array_slice($nombresAreas, 0, 3) as $nombreArea) {
                $encargado = User::create([
                    'name' => 'Encargado '.$nombreArea.' '.$sucursal->nombre,
                    'email' => strtolower(str_replace(' ', '.', $nombreArea.'.'.$sucursal->id)).'@eltornillo.hn',
                    'password' => bcrypt('password'),
                    'empresa_id' => $empresa->id,
                    'estado' => 'activo',
                    'email_verified_at' => now(),
                ]);
                $encargado->assignRole('encargado_area');

                $area = Area::create([
                    'sucursal_id' => $sucursal->id,
                    'nombre' => $nombreArea,
                    'descripcion' => $nombreArea.' de '.$sucursal->nombre,
                    'encargado_id' => $encargado->id,
                    'estado' => 'activo',
                ]);

                $areas->push($area);
            }
        }

        $nombresItems = [
            'Martillo', 'Destornillador plano', 'Destornillador estrella', 'Cinta metrica',
            'Tornillo 1/2 pulgada', 'Tornillo 1 pulgada', 'Tuerca hexagonal', 'Clavo comun',
            'Pintura blanca', 'Pintura negra', 'Brocha 2 pulgadas', 'Rodillo',
            'Cable electrico', 'Toma corriente', 'Interruptor', 'Bombillo LED',
            'Cinta aislante', 'Candado', 'Llave inglesa', 'Nivel de burbuja',
        ];

        $items = collect();

        foreach ($nombresItems as $nombre) {
            $items->push(Item::create([
                'empresa_id' => $empresa->id,
                'categoria_id' => $categorias->random()->id,
                'unidad_medida_id' => collect($unidades)->random()->id,
                'proveedor_id' => $proveedor->id,
                'nombre' => $nombre,
                'sku' => 'SKU-'.strtoupper(substr(md5($nombre), 0, 8)),
                'costo_unitario' => rand(20, 500),
                'stock_minimo' => 5,
                'estado' => 'activo',
            ]));
        }

        foreach ($items as $item) {
            $area = $areas->random();
            $cantidadInicial = rand(3, 40);

            InventarioArea::create([
                'item_id' => $item->id,
                'area_id' => $area->id,
                'cantidad' => $cantidadInicial,
            ]);

            MovimientoInventario::create([
                'item_id' => $item->id,
                'tipo' => 'entrada',
                'cantidad' => $cantidadInicial,
                'area_destino_id' => $area->id,
                'usuario_id' => $admin->id,
                'motivo' => 'Carga inicial de inventario',
            ]);
        }

        for ($i = 0; $i < 8; $i++) {
            $item = $items->random();
            $inventario = InventarioArea::where('item_id', $item->id)->first();

            if (! $inventario || $inventario->cantidad < 2) {
                continue;
            }

            $cantidad = min($inventario->cantidad, rand(1, 5));
            $inventario->cantidad -= $cantidad;
            $inventario->save();

            MovimientoInventario::create([
                'item_id' => $item->id,
                'tipo' => 'salida',
                'cantidad' => $cantidad,
                'area_origen_id' => $inventario->area_id,
                'usuario_id' => $admin->id,
                'motivo' => 'Venta a cliente',
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            $item = $items->random();
            $origen = InventarioArea::where('item_id', $item->id)->first();
            $destino = $areas->where('id', '!=', $origen?->area_id)->random();

            if (! $origen || $origen->cantidad < 2) {
                continue;
            }

            $cantidad = min($origen->cantidad, rand(1, 3));
            $origen->cantidad -= $cantidad;
            $origen->save();

            $inventarioDestino = InventarioArea::firstOrNew(['item_id' => $item->id, 'area_id' => $destino->id]);
            $inventarioDestino->cantidad = $inventarioDestino->cantidad + $cantidad;
            $inventarioDestino->save();

            MovimientoInventario::create([
                'item_id' => $item->id,
                'tipo' => 'traslado',
                'cantidad' => $cantidad,
                'area_origen_id' => $origen->area_id,
                'area_destino_id' => $destino->id,
                'usuario_id' => $admin->id,
                'motivo' => 'Reabastecimiento entre areas',
            ]);
        }
    }
}
