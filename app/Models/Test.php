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

class Test extends Model
{
    use AsSource, Chartable, Filterable, HasFactory, Notifiable, UserAccess;
    // Define the table if the name doesn't follow Laravel's convention
    protected $table = 'tests';

    // Specify the fillable attributes
    protected $fillable = [
        'test_type_id',
        'name',
        'description',
        'image',
        'open_class',
        'test_time',
        'marks',
        'xml_file',
        'status',
    ];

    // Optionally, you can define relationships here
    // Example: A test might belong to a test type
    public function testType()
    { 
        return $this->belongsTo(TestType::class , 'test_type_id');
    } 

  

    protected $allowedFilters = [
        'id'         => Where::class,
        'name'       => Like::class,
        'test_time'  => Like::class,
        'marks'      => Like::class,
        'updated_at' => Like::class,
        'created_at' => Like::class,
    ];

    protected $allowedSorts = [
        'id',
        'name',
        'test_time',
        'marks',
        'updated_at',
        'created_at',
    ];


}
