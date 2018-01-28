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
            //这个地方很巧妙，整个参数验证层的异常处理都放在这里了，其实剩下的验证层都只是定义了独有的验证方法，本来new validate类的时候传入的参数，特地在每个类中定义了
            //其实你想一下，验证层和别的异常处理不一样，验证层的错误都属于参数错误，不管是http code 还是error code 都应该一样的，所以我还是感觉整个验证层可以定义在一个重写的class泪中，封装了验证方法即可
            throw new ParamErrorException([
                'httpCode'=> 400,
                'errCode'=> 1002,
                'errMsg'=> $this->error]);  //这个地方因为不是错误，所以需要抛出，这样全局异常处理handle才能捕获到
        }

    }

    protected function idMustInt($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value+0)>0) {
            return true;
        } else {
            return false;
        }
    }


}