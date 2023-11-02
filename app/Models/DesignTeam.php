<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignTeam extends Model
{
    protected $table = "design_team";

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
