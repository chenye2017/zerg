<?php

namespace app\api\model;

use think\Model;

class Image extends BaseModel
{
    protected $hidden = ['update_time', 'delete_time'];
    //
    public function getUrlAttr($value, $data)
    {
        /*if ($data['from'] == 2) {
            return $value;
        }
        return config('setting.img_prefix').$value; //读取器的使用，$value代表这个属性的值*/
        return $this->prefixUrl($value, $data);
    }

    public function withCategory()
    {
        return $this->belongsTo('Category', 'id', 'topic_img_id');
    }

}
