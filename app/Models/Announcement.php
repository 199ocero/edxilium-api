<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory,HasApiTokens;

    protected $fillable = [
        'section_id',
        'subject_id',
        'deadline',
        'act_title',
        'instruction',
        'act_link',
        'attachment',
    ];
    protected $dates = ['deadline'];
}
