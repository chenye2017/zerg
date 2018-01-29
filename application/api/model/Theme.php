<?php

namespace app\api\model;

use app\lib\exception\ThemeException;
use think\Model;

class Theme extends Model
{
    protected $hidden = [
        "topic_img_id",
        "delete_time",
        "head_img_id",
        "update_time"
    ];
    //获取主题小图
    public function getTopicImg()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    //获取主题大图
    public function getHeadImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    //获取主题所有商品
    public function getProducts()
    {
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }

    //获取一组主题的信息
    public function getThemeByIds($ids)
    {
        $themes = self::with(['getTopicImg', 'getHeadImg'])->select($ids);
        if ($themes->isEmpty()) {
            throw new ThemeException();
        }
        return $themes;
    }

    //获取一个主题的详细信息
    public function getThemeInfo($id)
    {
        $theme = self::with(['getTopicImg', 'getHeadImg', 'getProducts'])->find($id);
        if (!$theme) {
            throw new ThemeException();
        }
        return $theme;
    }
}
