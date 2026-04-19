<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstatusMaquinaria extends Model
{
    protected $table = 'estatus_maquinaria';

    protected $fillable = ['nombre', 'color_badge', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function maquinarias()
    {
        return $this->hasMany(Maquinaria::class, 'estatus_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Retorna la clase Tailwind para el badge.
     */
    public function getBadgeClassAttribute(): string
    {
        return match ($this->color_badge) {
            'green'  => 'bg-green-100 text-green-800',
            'yellow' => 'bg-yellow-100 text-yellow-800',
            'red'    => 'bg-red-100 text-red-800',
            'blue'   => 'bg-blue-100 text-blue-800',
            default  => 'bg-gray-100 text-gray-800',
        };
    }
}