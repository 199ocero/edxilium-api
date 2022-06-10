<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Drop extends Model
{
    use HasFactory,HasApiTokens;

    protected $fillable = [
        'student_id',
        'section_id',
        'subject_id',
    ];
}
