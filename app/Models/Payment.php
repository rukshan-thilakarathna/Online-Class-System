<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'user_id',
        'month_id',
        'slip',
        // Add other attributes here as needed
    ];
}
