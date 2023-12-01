<?php

namespace App\Filament\Widgets;

// use Buildix\Timex\Models\Event;
use App\Models\Event;
use App\Models\Hgraph;
use Flowframe\Trend\Trend;
use Illuminate\Support\Carbon;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\HgraphResource;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;


    protected function getCards(): array
    {
        $hgraphs = Hgraph::query()->get();
        $min_created_at = DB::table('hgraphs')->min('created_at');
        $max_created_at = DB::table('hgraphs')->max('created_at');
        //get unique category 
        $categories = Hgraph::query()->select('category')->distinct()->get();
        $values = [];
        foreach ($categories as $product) {
            foreach(explode(',', $product->category) as $value) {
                $values[] = trim($value);
                }
        }
        $values = array_unique($values);

        $hraphs_chart = Trend::model(Hgraph::class)
        ->between(
            start: Carbon::createFromFormat('Y-m-d H:i:s',  $min_created_at),
            end:  Carbon::createFromFormat('Y-m-d H:i:s',  $max_created_at),
        )
        ->dateColumn('created_at')
        ->perDay()
        ->count();
       
        return [
            Stat::make('nhgraphs', $hgraphs->count())
            ->icon('heroicon-o-eye')
            ->label('Number of hgraphs')
            ->chart(
                $hraphs_chart 
                    ->map(fn (TrendValue $value) => $value->aggregate)
                    ->toArray()
            ),
            Stat::make('ncategories', count($values))
            ->icon('heroicon-o-eye')
            ->label('Number of categories')
            
        ];
    }
}
