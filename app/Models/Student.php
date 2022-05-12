<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory, HasApiTokens;
    
    protected $fillable = [
        'section_id',
        'facebook_id',
        'student_id',
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'gender',
        'contact_number',
        'email',
    ];
}
