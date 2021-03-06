<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Island extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    
    public function province()
    {
        return $this->hasMany(Province::class, 'island_id');
    }
    
    public function city()
    {
        return $this->hasMany(City::class, 'island_id');
    }
}
