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

    public function getUid()
    {
        $token = Request::instance()->header('token');
        if (!$token) {
            throw new ParamErrorException(
              ['msg'=>'需要传递token哦，才能调用api']
            );
        } else {
            $uid = getCacheValue($token, 'uid');
            return $uid;
        }

    }
}
