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

class Tutes extends Model
{
    use AsSource, Chartable, Filterable, HasFactory, Notifiable, UserAccess;
    // Define the table if the name doesn't follow Laravel's convention
    protected $table = 'tutes';


    // Specify the fillable attributes
    protected $fillable = [
        'title',
        'description',
        'pdf',
        'status'
    ];

    public const STATUS = [
        1 => 'Active',
        0 => 'Not Active',
    ];


    protected $allowedFilters = [
        'id'         => Where::class,
        'title'      => Like::class,
        'updated_at' => Like::class,
        'created_at' => Like::class,
    ];


    protected $allowedSorts = [
        'id',
        'title',
        'updated_at',
        'created_at',
    ];
}
