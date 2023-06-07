<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appreciation extends Model
{
    protected $table = "appreciations";

    protected $fillable = [
        'image'
    ];
}
