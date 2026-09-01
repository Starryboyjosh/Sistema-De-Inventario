<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('unidad_medida_id')->constrained('unidades_medida');
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores')->nullOnDelete();
            $table->string('nombre');
            $table->string('sku');
            $table->string('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->decimal('costo_unitario', 10, 2)->nullable();
            $table->integer('stock_minimo')->default(0);
            $table->string('estado')->default('activo');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['empresa_id', 'sku']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
