<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CatalogoCategoria extends Model
{
    protected $table = 'catalogo_categorias';

    protected $fillable = [
        'catalogo_id',
        'categoria_id',
        'descripcion',
        'orden',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'catalogo_id'  => 'integer',
        'categoria_id' => 'integer',
        'orden'        => 'integer',
        'status'       => 'integer',
    ];

    const STATUS_ELIMINADO = 0;
    const STATUS_BORRADOR  = 1;
    const STATUS_ACTIVO    = 2;

    // ─── Relaciones ──────────────────────────────────────
    public function catalogo()
    {
        return $this->belongsTo(Catalogo::class, 'catalogo_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'entidad_id')
            ->where('entidad', 'catalogo_categorias');
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function actualizadoPor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ─── Scopes ──────────────────────────────────────────
    public function scopeActivos(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVO);
    }

    public function scopeBorradores(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_BORRADOR);
    }

    public function scopeEliminados(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ELIMINADO);
    }

}
