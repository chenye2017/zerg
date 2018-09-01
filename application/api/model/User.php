<?php

namespace app\api\model;

use app\lib\exception\ParamErrorException;
use think\Model;
use think\Request;

class User extends Model
{
    //根据id查找用户
    public function getUserById($openid)
    {
        $result = self::where('openid', '=', $openid)->find();
        return $result;
    }

    public function createUser($openid)
    {
        $user = self::create([
            'openid'=>$openid
        ]);
        return $user->id;
    }


}
