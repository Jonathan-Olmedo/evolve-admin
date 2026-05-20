<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'orden',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'orden'  => 'integer',
        'status' => 'integer',
    ];

    const STATUS_ELIMINADO = 0;
    const STATUS_BORRADOR  = 1;
    const STATUS_ACTIVO    = 2;

    // ─── Relaciones ──────────────────────────────────────
    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function actualizadoPor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function catalogoCategorias()
    {
        return $this->hasMany(CatalogoCategoria::class, 'categoria_id');
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

    public function scopeOrdenados(Builder $query): Builder
    {
        return $query->orderBy('orden')->orderBy('nombre');
    }
}
