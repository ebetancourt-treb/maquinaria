<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BitacoraRegistro extends Model
{
    protected $table = 'bitacora_registros';

    protected $fillable = [
        'maquinaria_id', 'tipo_evento', 'fecha_evento', 'registrado_por',
        // Uso
        'horometro_anterior', 'horometro_actual',
        'kilometraje_anterior', 'kilometraje_actual',
        // Mantenimiento
        'tipo_mantenimiento', 'descripcion_trabajo', 'costo',
        'proveedor', 'proximo_mantenimiento',
        // Asignación
        'responsable_anterior_id', 'responsable_nuevo_id',
        'frente_anterior_id', 'frente_nuevo_id', 'motivo_asignacion',
        // Incidencia
        'tipo_incidencia', 'severidad', 'accion_tomada', 'requiere_paro',
        // Inspección
        'estado_general', 'checklist_json', 'aprobado',
        // Comunes
        'estatus_resultante_id', 'observaciones',
    ];

    protected $casts = [
        'fecha_evento'          => 'datetime',
        'proximo_mantenimiento' => 'date',
        'costo'                 => 'decimal:2',
        'horometro_anterior'    => 'decimal:2',
        'horometro_actual'      => 'decimal:2',
        'kilometraje_anterior'  => 'decimal:2',
        'kilometraje_actual'    => 'decimal:2',
        'checklist_json'        => 'array',
        'requiere_paro'         => 'boolean',
        'aprobado'              => 'boolean',
    ];

    /* ────────── Relaciones ────────── */

    public function maquinaria(): BelongsTo
    {
        return $this->belongsTo(Maquinaria::class);
    }

    public function registrador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    public function responsableAnterior(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_anterior_id');
    }

    public function responsableNuevo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_nuevo_id');
    }

    public function frenteAnterior(): BelongsTo
    {
        return $this->belongsTo(FrenteLaboral::class, 'frente_anterior_id');
    }

    public function frenteNuevo(): BelongsTo
    {
        return $this->belongsTo(FrenteLaboral::class, 'frente_nuevo_id');
    }

    public function estatusResultante(): BelongsTo
    {
        return $this->belongsTo(EstatusMaquinaria::class, 'estatus_resultante_id');
    }

    /* ────────── Scopes ────────── */

    public function scopeTipoEvento($query, string $tipo)
    {
        return $query->where('tipo_evento', $tipo);
    }

    public function scopeDeUso($query)
    {
        return $query->tipoEvento('uso');
    }

    public function scopeDeMantenimiento($query)
    {
        return $query->tipoEvento('mantenimiento');
    }

    public function scopeDeAsignacion($query)
    {
        return $query->tipoEvento('asignacion');
    }

    public function scopeDeIncidencia($query)
    {
        return $query->tipoEvento('incidencia');
    }

    public function scopeDeInspeccion($query)
    {
        return $query->tipoEvento('inspeccion');
    }

    public function scopeEntreFechas($query, string $desde, string $hasta)
    {
        return $query->whereBetween('fecha_evento', [$desde, $hasta]);
    }

    public function scopeDeMaquinaria($query, int $maquinariaId)
    {
        return $query->where('maquinaria_id', $maquinariaId);
    }

    public function scopeConParo($query)
    {
        return $query->where('requiere_paro', true);
    }

    public function scopeMantenimientosPendientes($query)
    {
        return $query->deMantenimiento()
            ->whereNotNull('proximo_mantenimiento')
            ->where('proximo_mantenimiento', '<=', now()->addDays(7));
    }

    /* ────────── Computed ────────── */

    public function getHorasUsoAttribute(): ?float
    {
        if ($this->horometro_actual && $this->horometro_anterior) {
            return round($this->horometro_actual - $this->horometro_anterior, 2);
        }
        return null;
    }

    public function getKilometrosRecorridosAttribute(): ?float
    {
        if ($this->kilometraje_actual && $this->kilometraje_anterior) {
            return round($this->kilometraje_actual - $this->kilometraje_anterior, 2);
        }
        return null;
    }

    public function getIconoEventoAttribute(): string
    {
        return match ($this->tipo_evento) {
            'uso'            => 'fa-clock',
            'mantenimiento'  => 'fa-wrench',
            'asignacion'     => 'fa-people-arrows',
            'incidencia'     => 'fa-triangle-exclamation',
            'inspeccion'     => 'fa-clipboard-check',
            default          => 'fa-circle',
        };
    }

    public function getColorEventoAttribute(): string
    {
        return match ($this->tipo_evento) {
            'uso'            => 'blue',
            'mantenimiento'  => 'amber',
            'asignacion'     => 'purple',
            'incidencia'     => 'red',
            'inspeccion'     => 'green',
            default          => 'gray',
        };
    }

    public function getEtiquetaEventoAttribute(): string
    {
        return match ($this->tipo_evento) {
            'uso'            => 'Registro de uso',
            'mantenimiento'  => 'Mantenimiento',
            'asignacion'     => 'Asignación / Traspaso',
            'incidencia'     => 'Incidencia',
            'inspeccion'     => 'Inspección',
            default          => $this->tipo_evento,
        };
    }
}