<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/27
 * Time: 21:39
 */

namespace app\lib\exception;

use app\lib\exception\BasicEception;

class BannerMissingException extends BasicEception
{
    public $httpCode = 404;
    public $errCode = 10001;
    public $errMsg = '没有找到对应id的banner';
}