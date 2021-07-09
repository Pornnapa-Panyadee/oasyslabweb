<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicationsMember extends Model
{
    protected $table = 'publication_members';
    protected $fillable = [
        'publication_id','member_id','order_member'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function members() {
        return $this->belongsTo('App\Models\Member', 'member_id', 'id');
    }
    public function publications() {
        return $this->belongsTo('App\Models\Publication', 'publication_id', 'id');
    }
}
