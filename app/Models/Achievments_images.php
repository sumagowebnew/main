<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievments_images extends Model
{
    protected $table = 'achievements_images';
    public function title()
    {
        return $this->belongsTo(Achievements::class);
    }
}
