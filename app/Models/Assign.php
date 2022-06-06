<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assign extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'instructor_id',
        'section_id',
        'subject_id',
        'school_year_id',
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class)->select(['id','first_name','middle_name','last_name']);
    }
    public function section()
    {
        return $this->belongsTo(Section::class)->select(['id','section']);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class)->select(['id','subject','year_level']);
    }
    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class)->select(['id','start_year','end_year']);
    }
}
