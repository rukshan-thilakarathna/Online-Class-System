<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QandA extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer_1',
        'answer_2',
        'answer_3',
        'answer_4',
        'correct_answer',
        'type_id',
        'test_id',
        'image',
        'marks',
        'time',
        'status',
    ];

    // Define relationships if needed
    // Example:
    // public function quiz() {
    //     return $this->belongsTo(Quiz::class);
    // }
}