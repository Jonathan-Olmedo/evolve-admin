<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Imagen extends Model
{
    protected $table = 'imagenes';

    protected $fillable = [
        'url',
        'entidad',
        'entidad_id',
        'orden',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'entidad_id' => 'integer',
        'orden'      => 'integer',
        'status'     => 'integer',
    ];

    const STATUS_ELIMINADO = 0;
    const STATUS_BORRADOR  = 1;
    const STATUS_ACTIVO    = 2;

    const ENTIDADES_VALIDAS = ['catalogos', 'catalogo_categorias'];

    // ─── Scopes ──────────────────────────────────────────
    public function scopeDeEntidad(Builder $query, string $entidad, int $id): Builder
    {
        return $query->where('entidad', $entidad)->where('entidad_id', $id);
    }

    public function scopeActivos(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVO);
    }

    public function scopeOrdenadas(Builder $query): Builder
    {
        return $query->orderBy('orden');
    }

    protected static function booted(): void
    {
        static::creating(function ($imagen) {
            if (empty($imagen->entidad)) {
                $imagen->entidad = 'catalogos';
            }
        });
    }
}
