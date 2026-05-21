<?php

namespace App\Filament\Resources\Catalogos\Tables;

use App\Models\Catalogo;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CatalogosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_url')
                    ->label('Logo')
                    ->circular()
                    ->width(40)
                    ->height(40),

                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('categorias_count')
                    ->counts('categorias')
                    ->label('Categorías')
                    ->badge(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn($state) => match((int)$state) {
                        Catalogo::STATUS_ELIMINADO => 'danger',
                        Catalogo::STATUS_BORRADOR  => 'warning',
                        Catalogo::STATUS_ACTIVO    => 'success',
                        default                    => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match((int)$state) {
                        Catalogo::STATUS_ELIMINADO => 'Eliminado',
                        Catalogo::STATUS_BORRADOR  => 'Borrador',
                        Catalogo::STATUS_ACTIVO    => 'Activo',
                        default                    => 'Desconocido',
                    }),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        Catalogo::STATUS_BORRADOR => 'Borrador',
                        Catalogo::STATUS_ACTIVO   => 'Activo',
                        Catalogo::STATUS_ELIMINADO => 'Eliminado',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('eliminar')
                    ->label('Eliminar')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->update([
                        'status' => Catalogo::STATUS_ELIMINADO
                    ])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('eliminar_seleccionados')
                        ->label('Eliminar seleccionados')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each->update([
                            'status' => Catalogo::STATUS_ELIMINADO
                        ])),
                ]),
            ])
            ->defaultSort('orden')
            ->modifyQueryUsing(fn ($query) => $query->noEliminados());
    }
}
