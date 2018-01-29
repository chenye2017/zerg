<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/1/29
 * Time: 20:10
 */

namespace app\lib\exception;


use app\lib\exception\BasicEception;

class ThemeException extends BasicEception
{
    public $httpCode = 404;
    public $errCode = 30000;
    public $errMsg = '没有找到Theme';
}