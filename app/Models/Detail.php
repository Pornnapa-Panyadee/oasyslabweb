<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        'keyword','th_name','en_name','th_description','en_description','path','amount'
    ];
}
