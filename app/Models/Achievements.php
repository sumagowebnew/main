<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievements extends Model
{
    protected $fillable = ['title'];
    
    public function image()
    {
        return $this->hasMany(Achievment_image::class);
    }
}
