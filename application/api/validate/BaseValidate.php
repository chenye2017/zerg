<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/26
 * Time: 20:16
 */

namespace app\api\validate;


use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        //获取所有参数
        $param = Request::instance()->param();
        $result = $this->check($param);
        if ($result) {
            return true;
        } else {
            throw new Exception($this->error);
        }
    }
}