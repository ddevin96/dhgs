<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Hgraph;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\ViewEntry;
use App\Filament\Resources\HgraphResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HgraphResource\RelationManagers;
use Filament\Infolists\Components\Tabs;
class HgraphResource extends Resource
{
    protected static ?string $model = Hgraph::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Forms\Components\TextInput::make('name')
    //                 ->required()
    //                 ->maxLength(255),
    //             Forms\Components\TextInput::make('category')
    //                 ->maxLength(255),
    //             Forms\Components\Textarea::make('description')
    //                 ->columnSpanFull(),
    //             Forms\Components\TextInput::make('nodes')
    //                 ->numeric(),
    //             Forms\Components\TextInput::make('edges')
    //                 ->numeric(),
    //             Forms\Components\TextInput::make('dnodemax')
    //                 ->numeric(),
    //             Forms\Components\TextInput::make('dedgemax')
    //                 ->numeric(),
    //             Forms\Components\TextInput::make('dnodeavg')
    //                 ->numeric(),
    //             Forms\Components\TextInput::make('dedgeavg')
    //                 ->numeric(),
    //             Forms\Components\Textarea::make('dnodes')
    //                 ->columnSpanFull(),
    //             Forms\Components\Textarea::make('dedges')
    //                 ->columnSpanFull(),
    //         ]);
    // }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make('Tabs')
                ->columnSpan('full')
                ->tabs([
                    Tabs\Tab::make('Graph data')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                        ]),
                    Tabs\Tab::make('Statistics')
                        ->schema([
                            ViewEntry::make('dnodes')->view('filament.infolists.chart-line')
                        ]),
                    Tabs\Tab::make('Download')
                        ->schema([
                            Infolists\Components\TextEntry::make('name')
                        ]),
                   
                ])
               
               
                // Infolists\Components\TextEntry::make('email'),
                // Infolists\Components\TextEntry::make('notes')
                //     ->columnSpanFull(),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nodes')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('edges')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dnodemax')
                    ->numeric()
                    ->label('Degree Node Max')
                    ->sortable(),
                Tables\Columns\TextColumn::make('dedgemax')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dnodeavg')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dedgeavg')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
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
            'index' => Pages\ListHgraphs::route('/'),
            'create' => Pages\CreateHgraph::route('/create'),
            'edit' => Pages\EditHgraph::route('/{record}/edit'),
            'view' => Pages\ViewHgraph::route('/{record}'),
        ];
    }
}
