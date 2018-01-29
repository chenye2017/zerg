<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/1/29
 * Time: 22:09
 */

namespace app\lib\exception;


class ProductException extends BasicEception
{
    public $httpCode = 404;
    public $errCode = 40000;
    public $errMsg = '没有找到Product';
}