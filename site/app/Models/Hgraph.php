<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Traits\UUID;
class Hgraph extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
       
       'name',
       'category',
       'url',
       'description',
       'nodes',
       'edges',
       'dnodemax',
       'dedgemax',
       'dnodeavg',
       'dedgeavg',
       'dnodes',
       'dedges'
    ];
   
}
