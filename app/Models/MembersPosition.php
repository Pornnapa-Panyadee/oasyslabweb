<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembersPosition extends Model
{
    protected $fillable = [
        'name_en', 'name_th','priority'
    ];

    protected $hidden = ['created_at', 'updated_at'];
    
    public static function store($data){
        $create = self::updateOrCreate(
            ['name_th' => $data['name_th'], 'name_en' => $data['name_en']],['priority' => $data['priority']]
        );
        if(!$create){
            return 'fail';
        }
        return 'done';
    }
}
