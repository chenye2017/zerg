<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2018/8/31
 * Time: 10:53
 */

namespace app\lib\exception;


class ForbiddenException extends BasicEception
{
    public $httpCode = 403;
    public $errCode = '';
    public $errMsg = '权限不够';
}