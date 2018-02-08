<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/2/6
 * Time: 19:39
 */

namespace app\api\service;


use app\api\model\User as UserModel;
use app\lib\exception\GetWxOpenIdErr;
use app\lib\exception\TokenSaveErr;
use think\Exception;


class UserToken extends Token
{
    protected $code;
    protected $app_id;
    protected $app_secret;
    protected $get_token_url;

    public function __construct($code)
    {
        $this->code = $code;
        $this->app_id = config('wx.app_id');
        $this->app_secret = config('wx.app_secret');
        $this->get_token_url = config('wx.get_token_url');
    }

    public function get()
    {
        $url = sprintf($this->get_token_url, $this->app_id, $this->app_secret, $this->code);
        $token = my_curl($url, []);
        $wxReturn = json_decode($token, true);
        if (empty($token)) {
            throw new Exception('获取token失败');
        } else {
            $loginFail = array_key_exists('errcode', $wxReturn);
            if ($loginFail) {
                $this->handleGetOpenIdErr($wxReturn);
            } else {
                $token = $this->getToken($wxReturn);
                return $token;
            }
        }
    }

    //思路：
    //拿到openid,到用户表里面查找这个用户是否存在
    //存在，直接返回uid，不存在创造user,也返回uid
    //uid取到之后，作为value存储起来，进缓存，和之前的wx返回值，scope一起作为一个key value里面的value
    private function getToken($wxReturn)
    {
        $openid = $wxReturn['openid'];
        $userModel = new UserModel();
        $userinfo = $userModel->getUserById($openid);
        $uid = $userinfo['id'];
        if ($uid) {

        } else {
            $uid = $userModel->createUser($openid);
        }
        $cacheData = $this->prepareCacheData($uid, $wxReturn); //key,value的value部分
        $token = $this->saveToken($cacheData);
        return $token;
    }

    public function saveToken($cacheData)
    {
        $token = $this->generateToken(32);
        $expire_in_time = config('wx.token_expire_in');
        $save = cache($token, $cacheData, $expire_in_time);
        if (!$save) {
            throw new TokenSaveErr();
        } else {
            return $token;
        }
    }

    protected function prepareCacheData($uid, $wxReturn, $scope = 16)
    {
        $cacheData = $wxReturn;
        $cacheData['uid'] = $uid;
        $cacheData['scope'] = $scope;
        return $cacheData;
    }

    //获取openid的异常处理
    private function handleGetOpenIdErr($result)
    {
        throw new GetWxOpenIdErr([
           'errCode'=>$result['errcode'],
            'errMsg'=>$result['errmsg']
        ]);
    }

}