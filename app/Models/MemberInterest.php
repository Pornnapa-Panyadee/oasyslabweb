<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberInterest extends Model
{
    protected $table = 'research_interest_members';
    protected $fillable = [
        'field_id','member_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];
    public static function store($data){
        $create = self::updateOrCreate(
            ['field_id' => $data['field_id'], 'member_id' => $data['member_id']]
        );
        if(!$create){
            return 'fail';
        }
        return 'done';
    }
    public function fieldInterest() {
        return $this->hasOne('App\Models\ResearchInterest', 'id', 'field_id');
    }
    public function member() {
        return $this->hasOne('App\Models\Member', 'id', 'member_id');
    }
}
