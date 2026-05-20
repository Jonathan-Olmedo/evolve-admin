<?php

namespace App\Filament\Resources\Catalogos;

use App\Filament\Resources\Catalogos\Pages\CreateCatalogo;
use App\Filament\Resources\Catalogos\Pages\EditCatalogo;
use App\Filament\Resources\Catalogos\Pages\ListCatalogos;
use App\Filament\Resources\Catalogos\Schemas\CatalogoForm;
use App\Filament\Resources\Catalogos\Tables\CatalogosTable;
use App\Models\Catalogo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatalogoResource extends Resource
{
    protected static ?string $model = Catalogo::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static ?string $navigationLabel = 'Catálogos';
    protected static ?string $modelLabel = 'Catálogo';
    protected static ?string $pluralModelLabel = 'Catálogos';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return CatalogoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CatalogosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListCatalogos::route('/'),
            'create' => CreateCatalogo::route('/create'),
            'edit'   => EditCatalogo::route('/{record}/edit'),
        ];
    }
}
