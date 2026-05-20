<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::activos()
            ->ordenados()
            ->get()
            ->map(fn($categoria) => [
                'id'          => $categoria->id,
                'nombre'      => $categoria->nombre,
                'descripcion' => $categoria->descripcion,
                'orden'       => $categoria->orden,
            ]);

        return response()->json(['data' => $categorias]);
    }
}
