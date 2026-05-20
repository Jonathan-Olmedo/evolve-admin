<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Catalogo;

class CatalogoController extends Controller
{
    public function index()
    {
        $catalogos = Catalogo::activos()
            ->ordenados()
            ->with([
                'catalogoCategorias' => function ($q) {
                    $q->where('status', 2)
                      ->orderBy('orden')
                      ->with([
                          'categoria',
                          'imagenes' => fn($i) => $i->activos()->ordenadas(),
                      ]);
                },
                'imagenes' => fn($q) => $q->activos()->ordenadas(),
            ])
            ->get()
            ->map(fn($c) => $this->formatCatalogo($c));

        return response()->json(['data' => $catalogos]);
    }

    public function show($id)
    {
        $catalogo = Catalogo::activos()
            ->with([
                'catalogoCategorias' => function ($q) {
                    $q->where('status', 2)
                      ->orderBy('orden')
                      ->with([
                          'categoria',
                          'imagenes' => fn($i) => $i->activos()->ordenadas(),
                      ]);
                },
                'imagenes' => fn($q) => $q->activos()->ordenadas(),
            ])
            ->findOrFail($id);

        return response()->json(['data' => $this->formatCatalogo($catalogo)]);
    }

    private function formatCatalogo($catalogo): array
    {
        return [
            'id'          => $catalogo->id,
            'nombre'      => $catalogo->nombre,
            'descripcion' => $catalogo->descripcion,
            'email'       => $catalogo->email,
            'pagina_web'  => $catalogo->pagina_web,
            'logo_url'    => $catalogo->logo_url
                                ? asset('storage/' . $catalogo->logo_url)
                                : null,
            'orden'       => $catalogo->orden,
            'categorias'  => $catalogo->catalogoCategorias->map(fn($cc) => [
                'id'          => $cc->categoria->id,
                'nombre'      => $cc->categoria->nombre,
                'descripcion' => $cc->descripcion ?? $cc->categoria->descripcion,
                'orden'       => $cc->orden,
                'imagenes'    => $cc->imagenes->map(fn($img) => [
                    'id'    => $img->id,
                    'url'   => asset('storage/' . $img->url),
                    'orden' => $img->orden,
                ]),
            ]),
            'imagenes'    => $catalogo->imagenes->map(fn($img) => [
                'id'    => $img->id,
                'url'   => asset('storage/' . $img->url),
                'orden' => $img->orden,
            ]),
            'created_at'  => $catalogo->created_at->toISOString(),
        ];
    }
}
