<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Orchid\Access\UserAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class ClassHasTest extends Model
{
    use AsSource, Chartable, Filterable, HasFactory, Notifiable, UserAccess;

    protected $fillable = [
        'class',
        'test',
        'month_number',
        'completed_count',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class , 'test');
    }

    public function testdata()
    {
        return $this->belongsTo(Test::class , 'test');
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class  , 'class');
    }
}
