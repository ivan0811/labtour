<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['province_id', 'island_id', 'name', 'url'];
    
    public function tour()
    {
        return $this->hasMany(Tour::class, 'city_id');
    }
    
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
        
    public function island()
    {
        return $this->belongsTo(Island::class);
    }
}
