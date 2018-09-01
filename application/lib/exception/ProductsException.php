<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2018/8/31
 * Time: 14:25
 */

namespace app\lib\exception;


class ProductsException extends BasicEception
{
    public $httpCode = 400;
    public $errCode = '';
    public $errMsg = 'products 参数不合法';
}