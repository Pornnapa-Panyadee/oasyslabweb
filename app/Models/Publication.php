<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = [
        'detail','total_members','type_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function publicationType() {
        return $this->hasOne('App\Models\PublicationsType', 'id', 'type_id');
    }

    public function publicationMembers() {
        return $this->hasMany('App\Models\PublicationsMember', 'publication_id', 'id');
    }
}
