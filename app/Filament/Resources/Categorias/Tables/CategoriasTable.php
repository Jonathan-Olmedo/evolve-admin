<?php

namespace App\Filament\Resources\Categorias\Tables;

use App\Models\Categoria;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CategoriasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->width(60),

                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('orden')
                    ->sortable()
                    ->width(80),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => match ((int)$state) {
                        Categoria::STATUS_ELIMINADO => 'danger',
                        Categoria::STATUS_BORRADOR  => 'warning',
                        Categoria::STATUS_ACTIVO    => 'success',
                        default                     => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match ((int)$state) {
                        Categoria::STATUS_ELIMINADO => 'Eliminado',
                        Categoria::STATUS_BORRADOR  => 'Borrador',
                        Categoria::STATUS_ACTIVO    => 'Activo',
                        default                     => 'Desconocido',
                    }),

                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        Categoria::STATUS_BORRADOR  => 'Borrador',
                        Categoria::STATUS_ACTIVO    => 'Activo',
                        Categoria::STATUS_ELIMINADO => 'Eliminado',
                    ])
                    ->label('Estado'),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('eliminar')
                    ->label('Eliminar')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->update(['status' => Categoria::STATUS_ELIMINADO])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('eliminar_seleccionados')
                        ->label('Eliminar seleccionados')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each->update(['status' => Categoria::STATUS_ELIMINADO])),
                ]),
            ])
            ->defaultSort('orden')
            ->modifyQueryUsing(fn ($query) => $query->activos());
    }
}
