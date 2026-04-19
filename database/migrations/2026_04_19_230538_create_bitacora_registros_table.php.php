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
        Schema::create('bitacora_registros', function (Blueprint $table) {
            $table->id();

            // ── Relación principal ──
            $table->foreignId('maquinaria_id')
                ->constrained('maquinarias')
                ->cascadeOnDelete();

            $table->enum('tipo_evento', [
                'uso', 'mantenimiento', 'asignacion', 'incidencia', 'inspeccion'
            ]);

            $table->dateTime('fecha_evento');
            $table->foreignId('registrado_por')
                ->constrained('users');

            // ── Uso diario (horómetro / kilometraje) ──
            $table->decimal('horometro_anterior', 10, 2)->nullable();
            $table->decimal('horometro_actual', 10, 2)->nullable();
            $table->decimal('kilometraje_anterior', 10, 2)->nullable();
            $table->decimal('kilometraje_actual', 10, 2)->nullable();

            // ── Mantenimiento ──
            $table->enum('tipo_mantenimiento', ['preventivo', 'correctivo'])
                ->nullable();
            $table->text('descripcion_trabajo')->nullable();
            $table->decimal('costo', 12, 2)->nullable();
            $table->string('proveedor', 150)->nullable();
            $table->date('proximo_mantenimiento')->nullable();

            // ── Asignación / Traspaso ──
            $table->foreignId('responsable_anterior_id')
                ->nullable()
                ->constrained('users');
            $table->foreignId('responsable_nuevo_id')
                ->nullable()
                ->constrained('users');
            $table->foreignId('frente_anterior_id')
                ->nullable()
                ->constrained('frentes_laborales');
            $table->foreignId('frente_nuevo_id')
                ->nullable()
                ->constrained('frentes_laborales');
            $table->string('motivo_asignacion', 255)->nullable();

            // ── Incidencia ──
            $table->enum('tipo_incidencia', [
                'falla_mecanica', 'falla_electrica', 'accidente',
                'robo', 'vandalismo', 'desgaste',
            ])->nullable();
            $table->enum('severidad', ['baja', 'media', 'alta', 'critica'])
                ->nullable();
            $table->text('accion_tomada')->nullable();
            $table->boolean('requiere_paro')->default(false);

            // ── Inspección ──
            $table->enum('estado_general', ['bueno', 'regular', 'malo'])
                ->nullable();
            $table->json('checklist_json')->nullable();
            $table->boolean('aprobado')->nullable();

            // ── Campos comunes ──
            $table->foreignId('estatus_resultante_id')
                ->nullable()
                ->constrained('estatus_maquinaria');
            $table->text('observaciones')->nullable();

            $table->timestamps();

            // ── Índices ──
            $table->index('tipo_evento');
            $table->index('fecha_evento');
            $table->index(['maquinaria_id', 'tipo_evento']);
            $table->index(['maquinaria_id', 'fecha_evento']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora_registros');
    }
};
