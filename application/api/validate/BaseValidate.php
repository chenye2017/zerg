<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/26
 * Time: 20:16
 */

namespace app\api\validate;


use app\lib\exception\ParamErrorException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        //获取所有参数
        $param = Request::instance()->param();
        $result = $this->batch()->check($param);//这个只是bool值,$this->error 才能获取到真正的错误信息，validate可以自定义错误信息
        if ($result) {
            return true;
        } else {
            throw new ParamErrorException([
                'httpCode'=> 400,
                'errCode'=> 1002,
                'errMsg'=> $this->error]);  //这个地方因为不是错误，所以需要抛出，这样全局异常处理handle才能捕获到
        }

    }
}