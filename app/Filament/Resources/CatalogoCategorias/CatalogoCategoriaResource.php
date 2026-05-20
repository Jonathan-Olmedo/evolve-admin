<?php

namespace App\Filament\Resources\CatalogoCategorias;

use App\Filament\Resources\CatalogoCategorias\Pages\CreateCatalogoCategoria;
use App\Filament\Resources\CatalogoCategorias\Pages\EditCatalogoCategoria;
use App\Filament\Resources\CatalogoCategorias\Pages\ListCatalogoCategorias;
use App\Filament\Resources\CatalogoCategorias\Schemas\CatalogoCategoriaForm;
use App\Filament\Resources\CatalogoCategorias\Tables\CatalogoCategoriasTable;
use App\Models\CatalogoCategoria;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatalogoCategoriaResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = CatalogoCategoria::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'descripcion';

    public static function form(Schema $schema): Schema
    {
        return CatalogoCategoriaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CatalogoCategoriasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCatalogoCategorias::route('/'),
            'create' => CreateCatalogoCategoria::route('/create'),
            'edit' => EditCatalogoCategoria::route('/{record}/edit'),
        ];
    }
}
