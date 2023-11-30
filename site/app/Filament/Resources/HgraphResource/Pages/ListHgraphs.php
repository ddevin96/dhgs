<?php

namespace App\Filament\Resources\HgraphResource\Pages;

use App\Filament\Resources\HgraphResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHgraphs extends ListRecords
{
    protected static string $resource = HgraphResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
