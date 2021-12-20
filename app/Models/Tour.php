<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    protected $fillable = ['city_id', 'name'];
    
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    
    public function comment()
    {
        return $this->hasMany(Comments::class, 'tour_id');
    }
}
