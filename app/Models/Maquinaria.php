<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


use Illuminate\Database\Eloquent\Model;

class Maquinaria extends Model
{
    use SoftDeletes;
    protected $fillable = [
            'tipo_id', 'numero_serie', 'identificador', 'descripcion',
            'color', 'marca_id', 'modelo', 'placas', 'responsable_id',
            'frente_id', 'estatus_id', 'ubicacion_id', 'notas', 'horometro_actual', 'kilometraje_actual'
        ];
    
        protected $casts = [
            'horometro_actual' => 'integer',
            'kilometraje_actual' => 'integer',
        ];

    /* ────────── Relaciones ────────── */

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(TipoMaquinaria::class, 'tipo_id');
    }

    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function frente(): BelongsTo
    {
        return $this->belongsTo(FrenteLaboral::class, 'frente_id');
    }

    public function estatus(): BelongsTo
    {
        return $this->belongsTo(EstatusMaquinaria::class, 'estatus_id');
    }

    public function ubicacion(): BelongsTo
    {
        return $this->belongsTo(Ubicacion::class, 'ubicacion_id');
    }

    /* ────────── Scopes ────────── */

    public function scopeDisponible($query)
    {
        return $query->whereHas('estatus', fn ($q) => $q->where('nombre', 'DISPONIBLE'));
    }

    public function scopeEnObra($query)
    {
        return $query->whereHas('estatus', fn ($q) => $q->where('nombre', 'OBRA'));
    }

    public function scopeDelFrente($query, int $frenteId)
    {
        return $query->where('frente_id', $frenteId);
    }

    public function scopeDelResponsable($query, int $userId)
    {
        return $query->where('responsable_id', $userId);
    }

    /* ────────── Helpers ────────── */

    /**
     * Genera el siguiente identificador para un tipo dado.
     * Ej: Tipo "Bailarina" con prefijo "BA" → "BA-0001", "BA-0002"
     */
    public static function generarIdentificador(TipoMaquinaria $tipo): string
    {
        $ultimo = static::withTrashed()
            ->where('tipo_id', $tipo->id)
            ->where('identificador', 'like', $tipo->prefijo_id . '-%')
            ->orderByRaw("CAST(SUBSTRING_INDEX(identificador, '-', -1) AS UNSIGNED) DESC")
            ->value('identificador');

        $consecutivo = $ultimo
            ? (int) last(explode('-', $ultimo)) + 1
            : 1;

        return $tipo->prefijo_id . '-' . str_pad($consecutivo, 4, '0', STR_PAD_LEFT);
    }

    public function bitacora(): HasMany
    {
        return $this->hasMany(BitacoraRegistro::class)
            ->orderByDesc('fecha_evento');
    }

    public function ultimoRegistroUso()
    {
        return $this->hasOne(BitacoraRegistro::class)
            ->where('tipo_evento', 'uso')
            ->orderByDesc('fecha_evento');
    }

    public function ultimoMantenimiento()
    {
        return $this->hasOne(BitacoraRegistro::class)
            ->where('tipo_evento', 'mantenimiento')
            ->orderByDesc('fecha_evento');
    }

    public function proximoMantenimiento()
    {
        return $this->hasOne(BitacoraRegistro::class)
            ->where('tipo_evento', 'mantenimiento')
            ->whereNotNull('proximo_mantenimiento')
            ->where('proximo_mantenimiento', '>=', now())
            ->orderBy('proximo_mantenimiento');
    }

    // ── Scopes adicionales ──
    public function scopeConMantenimientoProximo($query, int $dias = 7)
    {
        return $query->whereHas('bitacora', function ($q) use ($dias) {
            $q->deMantenimiento()
            ->whereNotNull('proximo_mantenimiento')
            ->where('proximo_mantenimiento', '<=', now()->addDays($dias));
        });
    }

    public function scopeConIncidenciasAbiertas($query)
    {
        return $query->whereHas('bitacora', function ($q) {
            $q->deIncidencia()->where('requiere_paro', true);
        })->whereHas('estatus', fn ($q) => $q->where('nombre', 'NO FUNCIONAL'));
    }

    // ── Helpers ──
    /**
     * Verifica si el tipo de esta máquina usa horómetro.
     */
    public function usaHorometro(): bool
    {
        return in_array($this->tipo?->tipo_medicion, ['horometro', 'ambos']);
    }

    /**
     * Verifica si el tipo de esta máquina usa kilometraje.
     */
    public function usaKilometraje(): bool
    {
        return in_array($this->tipo?->tipo_medicion, ['kilometraje', 'ambos']);
    }

}

