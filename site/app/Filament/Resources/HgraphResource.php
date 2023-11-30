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
use Filament\Infolists\Components;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use App\Filament\Resources\HgraphResource\Pages;
use Filament\Infolists\Components\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HgraphResource\RelationManagers;
use Filament\Infolists\Components\Actions;

class HgraphResource extends Resource
{
    protected static ?string $model = Hgraph::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('category')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('nodes')
                    ->numeric(),
                Forms\Components\TextInput::make('edges')
                    ->numeric(),
                Forms\Components\TextInput::make('dnodemax')
                    ->numeric(),
                Forms\Components\TextInput::make('dedgemax')
                    ->numeric(),
                Forms\Components\TextInput::make('dnodeavg')
                    ->numeric(),
                Forms\Components\TextInput::make('dedgeavg')
                    ->numeric(),
                Forms\Components\Textarea::make('dnodes')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('dedges')
                    ->columnSpanFull(),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make('Tabs')
                ->columnSpan('full')
                ->persistTabInQueryString()
                ->tabs([
                    Tabs\Tab::make('Graph data')
                    ->schema([
                        Components\Section::make()
                        ->schema([
                            Components\Grid::make(2)
                            ->schema([
                                Components\Group::make([
                                    Infolists\Components\TextEntry::make('name'),
                                    Infolists\Components\TextEntry::make('category')->badge()->color('danger')
                                   
                                ]),
                                Components\Group::make([
                                    Infolists\Components\TextEntry::make('created_at')->badge()->color('primary'),
                                    Infolists\Components\TextEntry::make('updated_at')->badge()->color('success')
                                ]),
                                // Action::make('star')
                                // ->icon('heroicon-m-star')
                                // ,
                           
                            ])]),
                        Components\Section::make()
                            ->schema([
                                Components\Grid::make(2)
                                ->schema([
                                    Components\Group::make([
                                        Infolists\Components\TextEntry::make('nodes')->label('# Nodes'),
                                        Infolists\Components\TextEntry::make('edges')->label('# Edges'),
                                    ]),
                                    Components\Group::make([
                                        Infolists\Components\TextEntry::make('dnodemax')->label('Node degree max'),
                                        Infolists\Components\TextEntry::make('dedgemax')->label('Edge degree max'),
                                        Infolists\Components\TextEntry::make('dnodeavg')->label('Node degree avg'),
                                        Infolists\Components\TextEntry::make('dedgeavg')->label('Edge degree avg'),
                                    ]),
                                ]),
                                
                            ]),
                        Components\Section::make()
                            ->schema([
                                Infolists\Components\TextEntry::make('')->default('README.md')->columnSpanFull(),
                                ViewEntry::make('description')->view('filament.infolists.markdown')
                            ])
                       
                       
                        ]),
                    Tabs\Tab::make('Statistics')
                        ->schema([
                            Infolists\Components\TextEntry::make('')->default('Distribution of nodes by degree')->columnSpanFull(),
                            ViewEntry::make('dnodes')->view('filament.infolists.chart-line')->columnSpanFull(),
                            Infolists\Components\TextEntry::make('')->default('Distribution of edges by degree')->columnSpanFull(),
                            ViewEntry::make('dedges')->view('filament.infolists.chart-line')->columnSpanFull(),
                        ])
                    // Tabs\Tab::make('Download')
                    //     ->schema([
                    //         Infolists\Components\TextEntry::make('name')
                    //     ]),
                   
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
                    ->badge()->color('danger')
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
