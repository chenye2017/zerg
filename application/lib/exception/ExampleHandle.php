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
use think\Log;
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
            if (config('app_debug') == 'false') {
                return parent::render($e);
            } else {
                $this->httpCode = 500;
                $this->errCode = 999;
                $this->errMsg = '服务器内部错误不想告诉你';
                $this->recordLog($e->getMessage()); //服务器错误信息记录了日志
            }
        }
            return json(['errCode' => $this->errCode, 'errMsg' => $this->errMsg, 'request_url' => Request::instance()->url()], $this->httpCode);

    }
    public function recordLog($content)
    {
        Log::init([ 'type'  => 'file',
            // 日志保存目录
            'path'  => LOG_PATH,
            // 日志记录级别
            'level' => ['error'],]);
        Log::record($content, 'error');
    }
}