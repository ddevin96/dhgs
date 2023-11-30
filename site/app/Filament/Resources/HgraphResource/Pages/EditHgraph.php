<?php

namespace App\Filament\Resources\HgraphResource\Pages;

use App\Filament\Resources\HgraphResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHgraph extends EditRecord
{
    protected static string $resource = HgraphResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
