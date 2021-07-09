<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title_th', 'title_en', 'type_id','cover_path','cover_id','detail_th','detail_en',
        'order_no','completed', 'slug'
    ];

    public function images() {
        return $this->hasOne('App\Models\Upload', 'id', 'cover_id');
    }

    public static function store($data){
        $tempName = explode(" ", strtolower($data['slug']));
        $slug = join("-",$tempName);
        $data = [
            'slug' => $slug,
            'title_th' => $data['title_th'],
            'title_en' => $data['title_en'],
            'type_id' => $data['type_id'],
            'cover_path' => NULL,
            'cover_id' => $data['image_id'],
            'detail_th' => $data['detail_th'],
            'detail_en' => $data['detail_en'],
            'order_no' => $data['order_no'],
            'completed' => false,
        ];
        $article = self::create($data);
        if(!$article){
            return 'fail';
        }
        return 'done';
    }

    public static function edit_article($data,$id){
        $tempName = explode(" ", strtolower($data['slug']));
        $slug = join("-",$tempName);
        $data = [
            'slug' => $slug,
            'title_th' => $data['title_th'],
            'title_en' => $data['title_en'],
            'type_id' => $data['type_id'],
            'cover_path' => NULL,
            'cover_id' => $data['image_id'],
            'detail_th' => $data['detail_th'],
            'detail_en' => $data['detail_en'],
            'order_no' => $data['order_no'],
            'completed' => false,
        ];
        $article = self::whereId($id)->update($data);
        if(!$article){
            return 'fail';
        }
        return 'done';
    }

    public static function delete_article($data,$id){
        $article = self::whereId($id)->delete();
        if(!$article){
            return 'fail';
        }
        return 'done';
    }

}
