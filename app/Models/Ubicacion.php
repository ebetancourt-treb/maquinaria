<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'ubicaciones';

    protected $fillable = ['nombre', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function maquinarias()
    {
        return $this->hasMany(Maquinaria::class, 'ubicacion_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}