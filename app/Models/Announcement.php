<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory,HasApiTokens;

    protected $fillable = [
        'instructor_id',
        'section_id',
        'subject_id',
        'deadline',
        'act_title',
        'instruction',
        'act_link',
        'attachment',
    ];
    protected $dates = ['deadline'];

    public function section()
    {
        return $this->belongsTo(Section::class)->select(['id','section']);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class)->select(['id','subject','year_level']);
    }
    public function instructor()
    {
        return $this->belongsTo(Instructor::class)->select(['id','first_name','last_name']);
    }
}
