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

class Student extends Model
{
    use AsSource, Chartable, Filterable, HasFactory, Notifiable, UserAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'student_id',
        'c_code',
        'class_type',
        'guardian_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
        'grade',
        'whatsapp_number',
        'image',
        'address',
        'birthday',
        'gender',
        'status',
    ];

    protected $allowedSorts = [
        'id',
        'type',
        'student_id',
        'class_type',
        'guardian_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
        'grade',
        'whatsapp_number',
        'image',
        'address',
        'birthday',
        'gender',
        'status',
        'updated_at',
        'created_at',
    ];

    protected $allowedFilters = [
        'id'         => Like::class,
        'type'          => Like::class,
        'student_id'       => Like::class,
        'class_type'       => Like::class,
        'guardian_id'       => Like::class,
        'first_name'       => Like::class,
        'last_name'       => Like::class,
        'email'         => Like::class,
    'phone_number'       => Like::class,
'whatsapp_number'          => Like::class,
        'address'            => Like::class,
        'birthday'           => Like::class,
        'gender'          => WhereIn::class,
        'grade'          => WhereIn::class,
        'status'       => WhereIn::class,
        'updated_at'    => Like::class,
        'created_at' => Like::class,
 ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'birthday' => 'date',
        'gender' => 'integer',
        'status' => 'boolean',
    ];

    /**
     * Get the guardian associated with the student.
     */
    public function guardian()
    {
        return $this->belongsTo(Student::class, 'guardian_id');
    }

    /**
     * Get the students associated with the guardian (if this student is a guardian).
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'guardian_id');
    }
}
