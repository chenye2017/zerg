<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    //
    protected function prefixUrl($url, $data)
    {
        if ($data['from'] == 2) {
            return $url;
        }
        return config('setting.img_prefix').$url;
    }
}
