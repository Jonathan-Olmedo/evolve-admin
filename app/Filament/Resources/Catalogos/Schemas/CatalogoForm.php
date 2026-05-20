<?php

namespace App\Filament\Resources\Catalogos\Schemas;

use App\Models\Catalogo;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CatalogoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información General')
                    ->schema([
                        TextInput::make('nombre')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(150)
                            ->columnSpanFull(),

                        Textarea::make('descripcion')
                            ->label('Descripción')
                            ->rows(3)
                            ->columnSpanFull(),

                        TextInput::make('email')
                            ->label('Correo electrónico')
                            ->email()
                            ->maxLength(100),

                        TextInput::make('pagina_web')
                            ->label('Página web')
                            ->url()
                            ->maxLength(255),
                    ])->columns(2),

                Section::make('Configuración')
                    ->schema([
                        FileUpload::make('logo_url')
                            ->label('Logo')
                            ->image()
                            ->directory('logos')
                            ->columnSpanFull(),

                        TextInput::make('orden')
                            ->label('Orden')
                            ->numeric()
                            ->default(0),

                        Select::make('status')
                            ->label('Estado')
                            ->options([
                                Catalogo::STATUS_BORRADOR => 'Borrador',
                                Catalogo::STATUS_ACTIVO   => 'Activo',
                            ])
                            ->default(Catalogo::STATUS_BORRADOR)
                            ->required(),
                    ])->columns(2),

                Section::make('Categorías')
                    ->schema([
                        Select::make('categorias')
                            ->label('Categorías asignadas')
                            ->relationship('categorias', 'nombre')
                            ->multiple()
                            ->preload(),
                    ]),
            ]);
    }
}
