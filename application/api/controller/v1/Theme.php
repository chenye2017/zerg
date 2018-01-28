<?php

namespace app\api\controller\v1;

use app\api\validate\BaseValidate;
use app\api\validate\IdMustArray;
use think\Controller;
use think\Request;

class Theme extends Controller
{
    public function getSimpleList()
    {
        $validate = new IdMustArray([]);
        $validate->goCheck();
    }
}
