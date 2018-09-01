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
    public function goCheck($tmps = [])
    {
        //获取所有参数

        $param  = Request::instance()->param();
        //$param = $tmps?:$param;//if ($tmps) {var_dump($param,'ll', $tmps);exit;}
        $result = $this->batch()->check($param);//这个只是bool值,$this->error 才能获取到真正的错误信息，validate可以自定义错误信息
        if ($result) {
            return true;
        } else {
            //这个地方很巧妙，整个参数验证层的异常处理都放在这里了，其实剩下的验证层都只是定义了独有的验证方法，本来new validate类的时候传入的参数，特地在每个类中定义了
            //其实你想一下，验证层和别的异常处理不一样，验证层的错误都属于参数错误，不管是http code 还是error code 都应该一样的，所以我还是感觉整个验证层可以定义在一个重写的class泪中，封装了验证方法即可
            throw new ParamErrorException([
                'httpCode' => 400,
                'errCode'  => 10000,
                'errMsg'   => $this->error]);  //这个地方因为不是错误，所以需要抛出，这样全局异常处理handle才能捕获到
        }

    }

    protected function idMustInt($value)
    {
        if (is_numeric($value) && is_int($value * 1) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function isNotEmpty($value)
    {
        if (empty($value)) {
            return false;
        } else {
            return true;
        }

    }

    protected function isMobile($value)
    {
        $pattern = '/^1[34578]\d{9}$/';
        if (preg_match($pattern, $value)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 过滤只有rule里面定义的参数
     * @return array
     * @throws ParamErrorException
     */
    public function filterParam()
    {
        $param = Request::instance()->param();
        if (array_key_exists('uid', $param) || array_key_exists('user_id', $param)) {
            throw new ParamErrorException(
                ['msg' => '不要传入uid或者userid']
            );
        }

        $newParam = [];
        foreach ($this->rule as $key => $value) {
            $newParam[$key] = $param[$key];
        }
        return $newParam;
    }

}