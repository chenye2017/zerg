<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/1/30
 * Time: 21:28
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
       'code'=>'require|isNotEmpty'
    ];

    protected $message = [
        'code'=>'想拿到token必须要code来换啊'
    ];
}