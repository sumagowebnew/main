<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievements extends Model
{
    protected $fillable = ['title', 'other_attributes'];
    
    public function images()
    {
        return $this->hasMany(Achievment_images::class);
    }
}
