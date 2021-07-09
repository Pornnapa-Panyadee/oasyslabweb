<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Upload;

class Project extends Model
{
    protected $fillable = [
        'th_name', 'en_name','th_description','en_description','image_id','order_no','icon_active','icon'
    ];

    public function images() {
        return $this->hasOne('App\Models\Upload', 'id', 'image_id');
    }
}
