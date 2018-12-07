<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/1/29
 * Time: 23:46
 */

namespace app\api\model;


use app\lib\exception\CategoryException;

class Category extends BaseModel
{
    protected $hidden = ['create_time', 'delete_time', 'update_time'];

    public function withTopicImg()
    {
        return $this->hasOne('Image', 'id', 'topic_img_id');
    }

    public function getAllCategory()
    {
        //$categories = self::with(['withTopicImg'])->select();
        $categories = self::all([], ['withTopicImg']);
        if ($categories->isEmpty()) {
            throw new CategoryException();
        }
        return $categories;
    }
}