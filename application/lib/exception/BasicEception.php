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