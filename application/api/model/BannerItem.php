<?php

namespace app\api\model;

use think\Model;

class BannerItem extends Model
{
    protected $hidden = ['update_time', 'delete_time'];
    //找bannerItem的image
    public function img()
    {
        $img = $this->belongsTo('Image', 'img_id', 'id');
        return $img;
    }

}
