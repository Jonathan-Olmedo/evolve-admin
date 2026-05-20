<?php

namespace App\Filament\Resources\CatalogoCategorias\Pages;

use App\Filament\Resources\CatalogoCategorias\CatalogoCategoriaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCatalogoCategoria extends EditRecord
{
    protected static string $resource = CatalogoCategoriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
