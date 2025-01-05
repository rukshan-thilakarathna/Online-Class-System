<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Orchid\Access\UserAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Videos extends Model
{
    use AsSource, Chartable, Filterable, HasFactory, Notifiable, UserAccess;


    protected $fillable = [
        'title',
        'link',
        'status',
        'recoded_at',
        'description',
    ];

    public const STATUS = [
        1 => 'Active',
        0 => 'Not Active',
    ];

    public function classHasVideos()
    {
        return $this->hasMany(ClassHasVideos::class, 'video_id', 'id');
    }
}
