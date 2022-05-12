<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolYear extends Model
{
    use HasFactory, HasApiTokens;
    
    protected $fillable = [
        'start_year',
        'end_year',
    ];
    public function assign()
    {
        return $this->hasMany(Assign::class);
    }
}
