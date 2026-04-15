<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maquinarias', function (Blueprint $table) {
            $table->id();    
            $table->foreignId('tipo_id')->constrained('tipos_maquinaria');
            $table->string('numero_serie', 100)->nullable();
            $table->string('identificador', 30);    // "BA-1832"
            $table->string('descripcion', 255);
            $table->string('color', 50)->nullable();
            $table->foreignId('marca_id')->constrained('marcas');
            $table->string('modelo', 100)->nullable();
            $table->string('placas', 30)->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('users');
            $table->foreignId('frente_id')->nullable()->constrained('frentes_laborales');
            $table->foreignId('estatus_id')->nullable()->constrained('estatus_maquinaria');
            $table->foreignId('ubicacion_id')->nullable()->constrained('ubicaciones');
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique('identificador');
            $table->index('numero_serie');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquinarias');
    }
};
