<?php

namespace app\api\model;

use think\Model;

class ProductImage extends BaseModel
{
    //
    protected $hidden = ['delete_time'];

    public function imgUrl()
    {
        return $this->hasOne('image', 'id', 'img_id');
    }

}
