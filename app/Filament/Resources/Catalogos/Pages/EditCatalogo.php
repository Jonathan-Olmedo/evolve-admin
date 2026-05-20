<?php

namespace App\Filament\Resources\Catalogos\Pages;

use App\Filament\Resources\Catalogos\CatalogoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCatalogo extends EditRecord
{
    protected static string $resource = CatalogoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
