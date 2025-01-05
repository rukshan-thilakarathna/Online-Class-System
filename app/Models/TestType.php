<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestType extends Model
{
    use HasFactory;

     // Define the table if the name doesn't follow Laravel's convention
     protected $table = 'test_types';

     // Specify the fillable attributes
     protected $fillable = [
         'name',
         'url'
     ];

}
