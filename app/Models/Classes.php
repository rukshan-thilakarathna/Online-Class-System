<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        // Automatically generate a custom ID when creating a new record
        static::creating(function ($model) {
            if (!$model->id) {
                // Generate the custom ID
                $latestClass = static::latest('created_at')->first();
                $number = $latestClass ? intval(substr($latestClass->id, 6)) + 1 : 1;
                $model->id = 'CLASS-' . $number;
            }
        });
    }
}
