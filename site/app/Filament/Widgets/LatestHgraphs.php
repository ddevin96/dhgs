<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Event;
use App\Models\Hgraph;
use App\Models\Communication;
// use Buildix\Timex\Resources\EventResource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use App\Filament\Resources\EventResource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HgraphResource;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Console\Commands\MailNotificationCommand;

class LatestHgraphs extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $pollingInterval = '3s';


    public static ?string $heading = 'Latest updated graphs';

    protected static ?int $sort = 1;

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 10;
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'updated_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'asc';
    }

    protected function getTableQuery(): Builder
    {

    //    $now = now()->modify('midnight'); 
    //    $end = now()->modify('midnight')->modify('+31 day');
      
      
       return HgraphResource::getEloquentQuery();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Updated at')
                ->dateTime()
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Created at')
                ->dateTime()
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('name')
            ->searchable(),
            Tables\Columns\TextColumn::make('category')
                ->badge()->color('danger')
                ->separator(',')
                ->searchable(),
            Tables\Columns\TextColumn::make('nodes')
                ->label('# Nodes')
                ->numeric()
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('edges')
                ->numeric()
                ->label('# Edges')
                ->sortable(),
            Tables\Columns\TextColumn::make('dnodemax')
                ->numeric()
                ->toggleable(isToggledHiddenByDefault: true)
                ->label('Degree Node Max')
                ->sortable(),
            Tables\Columns\TextColumn::make('dedgemax')
                ->numeric()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('dnodeavg')
                ->numeric()
                ->sortable() ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('dedgeavg')
                ->numeric()
                ->sortable() ->toggleable(isToggledHiddenByDefault: true)
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('view')->label('')->icon('heroicon-m-eye')->color('secondary')
            ->url(fn (Hgraph $record): string => HgraphResource::getUrl('view', ['record' => $record])),
           
            // Tables\Actions\Action::make('edit')->label('')->icon('heroicon-m-pencil-square')
            //     ->url(fn (Event $record): string => EventResource::getUrl('edit', ['record' => $record])),
        ];
    }
}
