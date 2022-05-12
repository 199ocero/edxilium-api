<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory, HasApiTokens;
    
    protected $fillable = [
        'section',
    ];
    public function assign()
    {
        return $this->hasMany(Assign::class);
    }
    public function student()
    {
        return $this->hasMany(Student::class);
    }
}
