<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrenteLaboral extends Model
{
    protected $table = 'frentes_laborales';

    protected $fillable = ['nombre', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function maquinarias()
    {
        return $this->hasMany(Maquinaria::class, 'frente_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}