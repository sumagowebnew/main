<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = 'designations';

    public function DevelopementTeamDetails()
    {
        return $this->hasMany(DevelopementTeam::class);
    }

    public function AdminTeamDetails()
    {
        return $this->hasMany(AdminTeam::class);
    }

    public function TraineeTeamDetails()
    {
        return $this->hasMany(TraineeTeam::class);
    }
}
