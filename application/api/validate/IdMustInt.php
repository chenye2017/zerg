<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/26
 * Time: 19:46
 */

namespace app\api\validate;


use app\api\validate\BaseValidate;

class IdMustInt extends BaseValidate
{
    //这个地方自定义的rule，是对id这个类型数据的校验，别的key对应的数据就不能用这个校验了
    protected $rule = [
        'id'=>'require|idMustInt'
    ];
    protected function idMustInt($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value+0)>0) {
            return true;
        } else {
            return $field.'必须是真整数';
        }
    }
}