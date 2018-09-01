<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/26
 * Time: 19:46
 */

namespace app\api\validate;

class IdMustInt extends BaseValidate
{
    //这个地方自定义的rule，是对id这个类型数据的校验，别的key对应的数据就不能用这个校验了
    protected $rule = [
        'id' => 'require|idMustInt'
        //验证器这块的rule定义的数组对应每个变量，key对应变量名
    ];

    protected $message = [
        'id.idMustInt' => '必须是正整数'
    ];
}