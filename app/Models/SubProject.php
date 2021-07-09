<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubProject extends Model
{
    protected $fillable = [
        'th_name', 'en_name','th_description','en_description','external_path','image_id','main_id','order_no'
    ];

    public function images() {
        return $this->hasOne('App\Models\Upload', 'id', 'image_id');
    }
}
