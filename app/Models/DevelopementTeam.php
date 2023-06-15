<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevelopementTeam extends Model
{
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
