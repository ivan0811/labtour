<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $fillable = ['island_id', 'name'];
    
    public function City()
    {
        return $this->hasMany(City::class, 'city_id');
    }
    
    public function Island()
    {
        return $this->belongsTo(Island::class);
    }
    
}
