<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/2/6
 * Time: 21:05
 */

namespace app\lib\exception;


class GetWxOpenIdErr extends BasicEception
{
    public $httpCode = 500;
    public $errCode = 50000;
    public $errMsg = '获取微信openid失败';
}