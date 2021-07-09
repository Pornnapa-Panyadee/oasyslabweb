<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'th_name', 'en_name','th_description','en_description','image_id','order_no','email','position_id','level_id','slug'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function images() {
        return $this->hasOne('App\Models\Upload', 'id', 'image_id');
    }
    public function positions() {
        return $this->hasOne('App\Models\MembersPosition', 'id', 'position_id');
    }
    public function levels() {
        return $this->hasOne('App\Models\MembersLevel', 'id', 'level_id');
    }
    public function publications() {
        return $this->hasMany('App\Models\PublicationsMember', 'member_id', 'id');
    }
    public function fieldsInterest() {
        return $this->hasMany('App\Models\MemberInterest', 'member_id', 'id');
    }
}
