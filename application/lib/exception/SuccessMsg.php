<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/2/8
 * Time: 13:01
 */

namespace app\lib\exception;


class SuccessMsg extends BasicEception
{
    public $httpCode = 201;
    public $errCode = 0;
    public $errMsg = '请求成功';
}