<?php

namespace app\api\model;

use think\Model;

class UserAddress extends BaseModel
{
    //
    public function withUser()
    {
        return $this->belongsTo('user', 'user_id', 'id');
    }

    public function withUser1()
    {
        return $this->hasOne('user', 'id', 'user_id');
    }
}
