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

    }

    public function getQqAuthCode()
    {
        // AuthCode url
        $url = 'https://graph.qq.com/oauth2.0/authorize';
        $data = [
            'response_type' => 'code',
            'client_id' => '101532680',
            'redirect_uri' => urlencode('https://blog.chenye2017.cn/api/login/qqlogin'),
            'state' => 'from_qq'
        ];
        $query = http_build_query($data);
        $url .= $url.'?'.$query;
        $res = my_curl($url);
        var_dump($res, json_decode($res, true));exit;
    }
}