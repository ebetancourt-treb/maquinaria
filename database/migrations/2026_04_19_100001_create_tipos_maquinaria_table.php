<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tipos_maquinaria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('prefijo_id', 10);
            $table->enum('tipo_medicion', ['horometro', 'kilometraje', 'ambos', 'ninguno'])->default('ninguno');
            $table->string('descripcion', 255)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->unique('nombre');
            $table->unique('prefijo_id');
        });
    }
    public function down(): void { Schema::dropIfExists('tipos_maquinaria'); }
};
