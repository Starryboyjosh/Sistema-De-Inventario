<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items');
            $table->string('tipo');
            $table->integer('cantidad');
            $table->foreignId('area_origen_id')->nullable()->constrained('areas');
            $table->foreignId('area_destino_id')->nullable()->constrained('areas');
            $table->foreignId('usuario_id')->constrained('users');
            $table->string('motivo')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};
