<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembersLevel extends Model
{
    protected $fillable = [
        'name_th','name_en'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
