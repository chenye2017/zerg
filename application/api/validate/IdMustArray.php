<?php
namespace app\api\validate;


class IdMustArray extends BaseValidate
{
    protected $message = [
        'id.idMustArray'=>'必须是以逗号分隔的正整数字符串，不能为空'
    ];

    protected $rule = [
        'id' => 'require|idMustArray'
    ];

    //这些自定义的验证方法传入的参数就是rule里面定义的参数，不用考虑怎么获取参数的，获取参数在basevalidate类里面定义的，这个只用任务传入的是一个参数就可以了
    protected function idMustArray($value)
    {
        $idArray = explode(',', $value);
        if (empty($idArray)) {
            return false;
        }

        foreach ($idArray as $value) {
            if (!$this->idMustInt($value)) {
                return false;
            }

        }
        return true;
    }
}