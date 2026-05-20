<?php

namespace App\Filament\Resources\Catalogos\Schemas;

use App\Models\Catalogo;
use App\Models\Categoria;
use App\Models\Imagen;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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

            ->columns(2)
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
                    ])->columns(2)->columnSpan(1),

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
                    ])->columns(2)->columnSpan(1),
                Section::make('Galería del catálogo')
                    ->schema([
                        Repeater::make('imagenes')
                            ->label('Imágenes')
                            ->relationship('imagenes')
                            ->schema([
                                FileUpload::make('url')
                                    ->label('')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('catalogos/galeria')
                                    ->required()
                                    ->columnSpanFull(),

                                // Ocultos, se manejan automáticamente
                                \Filament\Forms\Components\Hidden::make('status')
                                    ->default(Imagen::STATUS_ACTIVO),

                                \Filament\Forms\Components\Hidden::make('orden')
                                    ->default(0),
                            ])
                            ->columns(1)
                            ->defaultItems(0)
                            ->reorderable('orden')        // arrastra para reordenar y actualiza 'orden'
                            ->reorderableWithDragAndDrop()
                            ->grid(4)                     // muestra 4 por fila como galería
                            ->addActionLabel('+ Agregar imagen')
                            ->collapsed(false),
                    ])->columns(1)
            ->columnSpan(2),

                Section::make('Categorías')
                    ->schema([
                        Repeater::make('catalogoCategorias')
                            ->label('')
                            ->relationship('catalogoCategorias')
                            ->schema([
                                Select::make('categoria_id')
                                    ->label('Categoría')
                                    ->options(
                                        Categoria::activos()
                                            ->ordenados()
                                            ->pluck('nombre', 'id')
                                    )
                                    ->required()
                                    ->columnSpanFull(),

                                Textarea::make('descripcion')
                                    ->label('Descripción de esta categoría en el catálogo')
                                    ->rows(3)
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

                                // Galería de imágenes de esta categoría
                                Repeater::make('imagenes')
                                    ->label('Imágenes de esta categoría')
                                    ->relationship('imagenes')
                                    ->schema([
                                        FileUpload::make('url')
                                            ->label('')
                                            ->image()
                                            ->imageEditor()
                                            ->directory('catalogos/categorias')
                                            ->required()
                                            ->columnSpanFull(),

                                        \Filament\Forms\Components\Hidden::make('status')
                                            ->default(Imagen::STATUS_ACTIVO),

                                        \Filament\Forms\Components\Hidden::make('orden')
                                            ->default(0),
                                    ])
                                    ->columns(1)
                                    ->defaultItems(0)
                                    ->reorderable('orden')
                                    ->reorderableWithDragAndDrop()
                                    ->grid(3)
                                    ->addActionLabel('+ Agregar imagen')
                                    ->collapsed(false),
                            ])
                            ->addActionLabel('Agregar categoría')
                            ->defaultItems(0)
                            ->collapsed()
                            ->itemLabel(
                                fn(array $state): ?string =>
                                isset($state['categoria_id'])
                                    ? Categoria::find($state['categoria_id'])?->nombre
                                    : 'Nueva categoría'
                            ),
                    ])->columns(1)
            ->columnSpan(2),
            ]);
    }
}
