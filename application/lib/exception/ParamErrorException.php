<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/29
 * Time: 19:14
 */

namespace app\lib\exception;

use app\lib\exception\BasicEception;
use Throwable;

class ParamErrorException extends BasicEception
{
    public $httpCode = 400;
    public $errCode = 10000;
    public $errMsg = '参数错误';


}