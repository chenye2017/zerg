<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2018/8/31
 * Time: 17:48
 */

namespace app\api\validate;


class TestValidate extends BaseValidate
{
    protected $rule = [
        'test' => 'required'
    ];
}