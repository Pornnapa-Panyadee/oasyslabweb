<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicationsType extends Model
{
    protected $table = 'publication_types';

    protected $hidden = ['created_at', 'updated_at'];
    
    public function publications() {
        return $this->hasMany('App\Models\Publication', 'type_id', 'id')->orderBy('created_at','desc');
    }
}
