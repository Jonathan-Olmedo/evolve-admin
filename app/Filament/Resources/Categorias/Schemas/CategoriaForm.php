<?php

namespace App\Filament\Resources\Categorias\Schemas;

use App\Models\Categoria;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información General')
                    ->schema([
                        TextInput::make('nombre')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('orden')
                            ->numeric()
                            ->default(0),

                        Textarea::make('descripcion')
                            ->rows(3)
                            ->columnSpanFull(),

                        Select::make('status')
                            ->options([
                                Categoria::STATUS_BORRADOR  => 'Borrador',
                                Categoria::STATUS_ACTIVO    => 'Activo',
                            ])
                            ->default(Categoria::STATUS_BORRADOR)
                            ->required(),
                    ])->columns(2),
            ])->columns(1);
    }
}
