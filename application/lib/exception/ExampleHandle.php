<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/27
 * Time: 20:37
 */

namespace app\lib\exception;


use Exception;
use think\exception\Handle;
use think\Request;
use app\lib\exception\BasicEception;

class ExampleHandle extends Handle
{
    private $httpCode;
    private $errCode;
    private $errMsg;

    public function render(Exception $e)
    {

        if ($e instanceof BasicEception) {
            $this->httpCode = $e->httpCode;
            $this->errCode = $e->errCode;
            $this->errMsg = $e->errMsg;
        } else {
            $this->httpCode = 500;
            $this->errCode = 999;
            $this->errMsg = '服务器内部错误不想告诉你';
        }
        return json(['errCode'=>$this->errCode, 'errMsg'=>$this->errMsg, 'request_url'=>Request::instance()->url()], $this->httpCode);
    }
}