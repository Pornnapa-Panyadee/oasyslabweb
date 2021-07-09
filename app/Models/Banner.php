<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'image_id','image_path','external_path','order_no'
    ];

    public function image() {
        return $this->hasOne('App\Models\Upload', 'id', 'image_id');
    }
}
