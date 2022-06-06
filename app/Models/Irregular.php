<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Irregular extends Model
{
    use HasFactory, HasApiTokens;
    
    protected $fillable = [
        'instructor_id',
        'section_id',
        'subject_id',
        'student_id',
    ];
}
