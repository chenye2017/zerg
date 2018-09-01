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
use think\Request;
use app\lib\enum\UserScope;
use app\lib\exception\ForbiddenException;
use app\lib\exception\ParamErrorException;


class UserToken extends Token
{
    protected $code;
    protected $app_id;
    protected $app_secret;
    protected $get_token_url;

    /**
     * 拼接从wx获取openid的参数
     * UserToken constructor.
     * @param $code
     */
    public function __construct($code)
    {
        $this->code = $code;
        $this->app_id = config('wx.app_id');
        $this->app_secret = config('wx.app_secret');
        $this->get_token_url = config('wx.get_token_url');
    }

    /**
     * 获取用户登陆凭证token
     * @return array
     * @throws Exception
     * @throws GetWxOpenIdErr
     */
    public function get()
    {
        $url = sprintf($this->get_token_url, $this->app_id, $this->app_secret, $this->code);
        $token = my_curl($url, []);
        $wxReturn = json_decode($token, true);
        if (empty($token)) {
            throw new Exception('获取token失败');
        } else {
            $loginFail = array_key_exists('errcode', $wxReturn); //如果失败了errcode 就有值，如果成功了，就是0
            if ($loginFail) {
                $this->handleGetOpenIdErr($wxReturn);
            } else {
                $token = $this->getToken($wxReturn);
                return ['data'=>$token];
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

    /**
     * 保存token和用户的对应信息进入缓存中，方便检测
     * @param $cacheData
     * @return string
     * @throws TokenSaveErr
     */
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

    /**
     * token => 用户信息 写入缓存中
     * @param $uid
     * @param $wxReturn
     * @param int $scope
     * @return mixed
     */
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

    /**
     * 验证所有用用户权限
     * @throws \app\lib\exception\ParamErrorException
     */
    public static function needUserScope()
    {
        $userScope = getCacheValue(Request::instance()->header('token'), 'scope');
        if ($userScope >= UserScope::USER) {

        } else {
            throw new ForbiddenException();
        }
    }

    public static function needExclusiveScope()
    {
        $userScope = getCacheValue(Request::instance()->header('token'), 'scope');
        if ($userScope == UserScope::USER) {

        } else {
            throw new ForbiddenException();
        }
    }

    public static function getUid()
    {
        $token = Request::instance()->header('token');
        if (!$token) {
            throw new ParamErrorException(
                ['errMsg'=>'需要传递token哦，才能调用api']
            );
        } else {
            $uid = getCacheValue($token, 'uid');
            if (!$uid) {
                throw  new ParamErrorException(['errMsg'=>'token 错误，不合法']);
            }
            return $uid;
        }

    }

}