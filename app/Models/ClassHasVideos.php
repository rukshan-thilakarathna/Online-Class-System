<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Orchid\Access\UserAccess;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class ClassHasVideos extends Model
{
    use AsSource, Chartable, Filterable, HasFactory, Notifiable, UserAccess;


    protected $fillable = [
        'class_id',
        'video_id',
        'views',
        'month_number',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function video()
    {
        return $this->belongsTo(Videos::class, 'video_id');
    }


    
}
