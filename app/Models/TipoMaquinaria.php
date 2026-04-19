<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMaquinaria extends Model
{
    protected $table = 'tipos_maquinaria'; 

    protected $fillable = ['nombre', 'prefijo_id', 'descripcion', 'activo', 'tipo_medicion'];

    protected $casts = ['activo' => 'boolean'];

    public function maquinarias()
    {
        return $this->hasMany(Maquinaria::class, 'tipo_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function getEtiquetaMedicionAttribute(): string
    {
        return match ($this->tipo_medicion) {
            'horometro'   => 'Horómetro (hrs)',
            'kilometraje' => 'Kilometraje (km)',
            'ambos'       => 'Horómetro + Kilometraje',
            'ninguno'     => 'Sin medición',
            default       => $this->tipo_medicion,
        };
    }

}