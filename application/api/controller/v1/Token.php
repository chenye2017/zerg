<?php

namespace app\api\controller\v1;

use app\api\service\UserToken;
use app\api\validate\TokenGet;
use think\Controller;
use think\Request;

class Token extends Controller
{
    /**
     * 通过code 获取token
     * @param Request $req
     * @return \think\response\Json
     * @throws \app\lib\exception\GetWxOpenIdErr
     * @throws \app\lib\exception\ParamErrorException
     * @throws \think\Exception
     */
    public function getToken(Request $req)
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken();
        $userinfo = $ut->get($req->param('code'));
        $token = $userinfo['token'];
        return json([
            'code'=> 22222,
            'result'=> ['token'=>$token]
        ]);
    }
}
