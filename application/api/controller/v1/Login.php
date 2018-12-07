<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2018/12/7
 * Time: 10:18
 */

namespace app\api\controller\v1;


use think\Controller;
use think\Log;
use think\Request;

class Login extends Controller
{
    public function qqLogin()
    {
        $code = Request::instance()->get('code','error');
        $state = Request::instance()->get('state', 'www');

        $url = 'https://graph.qq.com/oauth2.0/token';
        $data = [
            'grant_type' => 'authorization_code',
            'client_id' => '101532880',
            'client_secret' => '694ab4d9f8bf3a235497514e3f3c56ef',
            'code' => $code,
            'redirect_uri' => 'https://blog.chenye2017.cn/api/login/qqlogin'
        ];
        $query = http_build_query($data);
        $url = $url.'?'.$query;
        $res = my_curl($url);
        parse_str($res,$arr);
        $accessToken = $arr['access_token'];


        $url = 'https://graph.qq.com/oauth2.0/me?access_token='.$accessToken;
        $res = my_curl($url);//var_dump($res);

        // callback( {"client_id":"YOUR_APPID","openid":"YOUR_OPENID"} );
        $num = strrpos($res, ':');
        $res = substr($res, $num);

        $start = strpos($res, '"');
        $end = strrpos($res, '"');
        $openid = substr($res, $start+1, $end-$start-1);
// openid = C78FBCE1F9041715BE92435B19F5F895;
        $url = 'https://graph.qq.com/user/get_user_info';
        $data = [
            'access_token' => $accessToken,
            'oauth_consumer_key' => '101532880',
            'openid' => $openid
        ];
        $url = $url.'?'. http_build_query($data);//var_dump($url);
        $res = my_curl($url);


        $res = json_decode($res, true);var_dump($res);exit;

    }



    public function test()
    {
        Log::record('ceshi');
        var_dump('sss');exit;
    }

    public function getQqAuthCode()
    {
        // AuthCode url
        $url = 'https://graph.qq.com/oauth2.0/authorize';
        $data = [
            'response_type' => 'code',
            'client_id' => '101532880',
            'redirect_uri' => 'https://blog.chenye2017.cn/api/login/qqlogin',
            'state' => 'from_qq'
        ];
        $query = http_build_query($data);
        $url = $url.'?'.$query;
        $res = my_curl($url);
        var_dump($url, $res, json_decode($res, true));exit;
    }


    public function weiboLogin()
    {
        $code = Request::instance()->get('code');
        $url = 'https://api.weibo.com/oauth2/access_token';
        $data = [
            'client_id' => '3577895359',
            'client_secret' => '1b936bbe419eef1e981ddfdd0eb3c80e',
            'grant_type' => 'authorization_code',
            'redirect_uri' => 'https://blog.chenye2017.cn/api/login/weibologin',
            'code' => $code
        ];
        $url = $url.'?'.http_build_query($data);
        $res = my_curl($url, ['state'=>'from_weibo']);
        $res = json_decode($res, true);
        $accessToken = $res['access_token'];

        $url = 'https://api.weibo.com/oauth2/get_token_info?access_token='.$accessToken;
        $res = my_curl($url, ['access_token' => $accessToken]);
        $res = json_decode($res, true);
        var_dump($res);exit;
    }

    public function getWbAuthCode()
    {
        $url = 'https://api.weibo.com/oauth2/authorize';
        $data = [
            'client_id' => '3577895359',
            'response_type' => 'code',
            'redirect_uri' => 'https://blog.chenye2017.cn/api/login/weibologin',
        ];
        $query = http_build_query($data);
        $url = $url.'?'.$query;var_dump($url);exit;
        $res = my_curl($url);
        var_dump($url, $res, json_decode($res, true));exit;
    }
}