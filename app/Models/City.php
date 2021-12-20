<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['province_id', 'name'];
    
    public function tours()
    {
        return $this->hasMany(Tour::class, 'tour_id');
    }
    
    public function provinces()
    {
        return $this->belongsTo(Province::class);
    }
}
