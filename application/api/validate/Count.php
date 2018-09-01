<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/1/29
 * Time: 22:03
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
        'count'=>'idMustInt|between:1,15'
        //验证器这块的rule定义的数组对应每个变量，key对应变量名
    ];

    protected $message = [
        'id.count'=> 'count 必须是正整数，在1到15之间，默认15'
    ];
}