<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientLogo extends Model
{
    protected $table = "client_logos";

    protected $fillable = [
        'image'
    ];
}
