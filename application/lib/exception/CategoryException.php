<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/1/29
 * Time: 23:50
 */

namespace app\lib\exception;


class CategoryException extends BasicEception
{
    public $httpCode = 404;
    public $errCode = 50000;
    public $errMsg = '没有找到Category';
}