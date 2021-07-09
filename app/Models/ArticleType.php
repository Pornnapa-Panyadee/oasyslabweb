<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleType extends Model
{
    protected $table = 'articles_type';

    protected $hidden = ['created_at', 'updated_at'];
    
    public function articles() {
        return $this->hasMany('App\Models\Article', 'type_id', 'id')->orderBy('order_no','desc');
    }
}
