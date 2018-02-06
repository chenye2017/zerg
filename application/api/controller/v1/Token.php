<?php

namespace app\api\controller\v1;

use app\api\service\UserToken;
use app\api\validate\TokenGet;
use think\Controller;
use think\Request;

class Token extends Controller
{
    public function getToken(Request $req)
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($req->param('code'));
        $token = $ut->get();
        return json([
            'code'=> 22222,
            'result'=> ['token'=>$token]
        ]);
    }
}
