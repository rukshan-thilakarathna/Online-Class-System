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

class Classes extends Model
{
    use AsSource, Chartable, Filterable, HasFactory, Notifiable, UserAccess;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'class_type',
        'class_category',
        'class_time_range',
        'grade',
        'class_fees',
        'class_fees_date',
        'class_year',
        'class_start_date',
        'class_date',
        'status'
    ];

    protected $allowedFilters = [
        'id'         => Where::class,
        'class_type'         => Where::class,
        'class_category'         => Where::class,
        'name'       => Like::class,
        'slug'      => Like::class,
        'grade'      => Like::class,
        'class_fees'      => Like::class,
        'class_year'      => Like::class,
        'class_start_date'      => Like::class,
        'updated_at' => WhereDateStartEnd::class,
        'created_at' => WhereDateStartEnd::class,
    ];


    protected $allowedSorts = [
        'id',
        'name',
        'slug',
        'grade',
        'class_fees',
        'class_year',
        'class_start_date',
        'updated_at',
        'created_at',
    ];

    public const STATUS = [
        1 => 'On Going',
        2 => 'Completed',
        3 => 'Upcoming',
    ];

    public const TYPES = [
        1 => 'On Going',
        2 => 'Completed',
        3 => 'Upcoming',
    ];

    protected $casts = [
        'class_date' => 'array', // Assuming class_date is stored as JSON
        'class_fees_date' => 'array' // Assuming class_fees_date is stored as JSON
    ];

    public function GetType()
    {
        return $this->belongsTo(ClassTypes::class, 'class_type');
    }

    public function GetCategory()
    {
        return $this->belongsTo(ClassCategories::class, 'class_category');
    }
}
