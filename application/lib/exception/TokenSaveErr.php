<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/2/6
 * Time: 23:28
 */

namespace app\lib\exception;


class TokenSaveErr extends BasicEception
{
    public $httpCode = 404;
    public $errCode = 10001;
    public $errMsg = 'Token保存失败';
}