<?php

namespace app\api\model;

use app\lib\exception\ProductException;
use think\Model;

class Product extends BaseModel
{
    //
    protected $hidden = [
        "create_time",
        "update_time",
        "pivot",
        "delete_time"
    ];

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixUrl($value, $data);
    }

    public function getRecent($count)
    {
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        if ($products->isEmpty()) {
            throw new ProductException();
        }
        return $products;
    }

    public function getAllInCategory($category_id)
    {
        $products = self::where('category_id', '=', $category_id)
            ->select();
        if ($products->isEmpty()) {
            throw new ProductException();
        }
        return $products;
    }
}
