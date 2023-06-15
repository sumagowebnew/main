<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TraineeTeam extends Model
{
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
