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

    public function __construct($data = [])
    {
        if (!is_array($data)) {
            return ;
        }
        if (array_key_exists('httpCode', $data)) {
            $this->httpCode = $data['httpCode'];
        }
        if (array_key_exists('errCode', $data)) {
            $this->httpCode = $data['errCode'];
        }
        if (array_key_exists('errMsg', $data)){
        $this->errMsg = $data['errMsg'];
        }
    }
}