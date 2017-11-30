<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/27
 * Time: 21:37
 */

namespace app\lib\exception;



class BasicEception extends \Exception
{
    public $httpCode;
    public $errCode;
    public $errMsg;
}