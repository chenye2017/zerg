<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/1/28
 * Time: 20:45
 */

namespace app\api\controller\v2;


use think\Request;

class Banner
{
    public function getBanner(Request $req)
    {
        return 'this is v2';
    }
}