<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Orchid\Access\UserAccess;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\WhereIn;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class StudentHasTest extends Model
{
    use AsSource, Chartable, Filterable, HasFactory, Notifiable, UserAccess;

    protected $table = 'student_has_tests';

    protected $fillable = [
        'student_id',
        'test_id',
        'class_id',
        'full_marks',
        'get_marks',
        'start_time',
        'end_time',
        'marks_percentage',
        'status',
    ];

    protected $allowedFilters = [
        'student_id' => Like::class, 
        'test_id'  => Like::class, 
        'class_id'  => Like::class, 
        'full_marks'  => Like::class, 
        'get_marks'  => Like::class, 
        'start_time'  => Like::class, 
        'end_time'  => Like::class, 
        'marks_percentage'  => Like::class, 
        'status'  => Like::class,
    ]; 

    protected $allowedSorts = [
        'student_id',

        'test_id',
        'class_id',
        'full_marks',
        'get_marks',
        'start_time',
        'end_time',
        'marks_percentage',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id','id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id','id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
