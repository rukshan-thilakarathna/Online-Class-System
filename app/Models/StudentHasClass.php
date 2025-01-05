<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Orchid\Access\UserAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class StudentHasClass extends Model
{
    use AsSource, Chartable, Filterable, HasFactory, Notifiable, UserAccess;

    // Specify the table if it's not the plural of the model name
    protected $table = 'student_has_classes';

    // Define fillable attributes
    protected $fillable = [
        'student_id',
        'class_id',
        'payment_has_classes_id',
        'video_access',
        'test_access',
        'tute_access'
    ];

    // Relationships (Assuming that you have related models for Student, Class, and PaymentHasClass)

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class); // Replace 'ClassModel' with the actual class model name
    }

    public function paymentHasClass()
    {
        return $this->belongsTo(PaymentHasClass::class , 'payment_has_classes_id');
    }
}
