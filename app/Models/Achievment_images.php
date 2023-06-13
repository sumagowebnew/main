<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievment_images extends Model
{
    public function title()
    {
        return $this->belongsTo(Achievemment::class);
    }
}
