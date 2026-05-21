<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Catalogo extends Model
{
    protected $table = 'catalogos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'email',
        'pagina_web',
        'logo_url',
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
    public function categorias()
    {
        return $this->belongsToMany(
            Categoria::class,
            'catalogo_categorias',
            'catalogo_id',
            'categoria_id'
        )->withPivot(['id', 'descripcion', 'orden', 'status'])
            ->withTimestamps();
    }

    public function catalogoCategorias()
    {
        return $this->hasMany(CatalogoCategoria::class, 'catalogo_id');
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'entidad_id')
            ->where('entidad', 'catalogos');
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

    public function scopeOrdenados(Builder $query): Builder
    {
        return $query->orderBy('orden')->orderBy('nombre');
    }

    public function scopeConCategorias(Builder $query): Builder
    {
        return $query->with([
            'categorias' => fn($q) => $q->where(
                'catalogo_categorias.status',
                self::STATUS_ACTIVO
            )
        ]);
    }
    public function scopeNoEliminados(Builder $query): Builder
{
    return $query->where('status', '!=', self::STATUS_ELIMINADO);
}
}
