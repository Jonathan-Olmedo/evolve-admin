<?php

namespace App\Filament\Resources\CatalogoCategorias\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CatalogoCategoriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('catalogo_id')
                    ->required()
                    ->numeric(),
                TextInput::make('categoria_id')
                    ->required()
                    ->numeric(),
                Textarea::make('descripcion')
                    ->columnSpanFull(),
                TextInput::make('orden')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('status')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('created_by')
                    ->numeric(),
                TextInput::make('updated_by')
                    ->numeric(),
            ]);
    }
}
