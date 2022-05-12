<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory, HasApiTokens;
    
    protected $fillable = [
        'subject',
        'year_level',
    ];
    public function assign()
    {
        return $this->hasMany(Assign::class);
    }
}
