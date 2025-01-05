<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestMarkingHistory extends Model
{
    use HasFactory;

    // Specify fillable fields
    protected $fillable = [
        'student_id',
        'test_id',
        'qanda_id',
        'correct_answer',
        'student_answer',
        'marks',
        'status',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }
}
