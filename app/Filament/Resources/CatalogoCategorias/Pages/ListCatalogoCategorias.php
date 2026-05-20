<?php

namespace App\Filament\Resources\CatalogoCategorias\Pages;

use App\Filament\Resources\CatalogoCategorias\CatalogoCategoriaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCatalogoCategorias extends ListRecords
{
    protected static string $resource = CatalogoCategoriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
