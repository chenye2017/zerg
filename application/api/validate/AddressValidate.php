<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/2/8
 * Time: 11:48
 */

namespace app\api\validate;


class AddressValidate extends BaseValidate
{
    protected $rule = [
        'name' => 'require|isNotEmpty',
        'mobile' => 'require|isMobile',
        'province' => 'require|isNotEmpty',
        'city' => 'require|isNotEmpty',
        'country' => 'require|isNotEmpty',
        'detail' => 'require|isNotEmpty'
    ];

    protected $message = [
        'name' => 'name必须传递，且不能为空',
        'mobile' => 'mobile必须传递,必须是手机号',
        'province' => 'province必须传递，且不能为空',
        'city' => 'city必须传递，且不能为空',
        'country' => 'country必须传递，且不能为空',
        'detail' => 'detail必须传递，且不能为空'
    ];
}