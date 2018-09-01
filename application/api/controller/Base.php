<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2018/8/31
 * Time: 12:17
 */

namespace app\api\controller;


use app\api\service\UserToken;
use think\Controller;

class Base extends Controller
{
    public function checkUserScope()
    {
        UserToken::needUserScope();
    }

    public function checkExclusiveScope()
    {
        UserToken::needExclusiveScope();
    }
}