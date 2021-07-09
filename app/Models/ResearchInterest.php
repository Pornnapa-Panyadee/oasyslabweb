<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchInterest extends Model
{
    protected $table = 'research_interest_fields';
    protected $fillable = [
        'name', 'slug'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function MembersInterest() {
        return $this->hasMany('App\Models\MemberInterest', 'field_id', 'id');
    }
}
