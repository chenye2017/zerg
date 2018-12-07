<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/27
 * Time: 20:37
 */

namespace app\lib\exception;



use think\exception\Handle;
use think\Log;
use think\Request;



class ExampleHandle extends Handle
{
    private $httpCode;
    private $errCode;
    private $errMsg;

    /**
     * 重写全局异常处理
     * @param Exception $e
     * @return \think\Response|\think\response\Json
     */
    public function render(\Exception $e)
    {
        // 已知异常
        if ($e instanceof BasicEception) {
            $this->httpCode = $e->httpCode;
            $this->errCode  = $e->errCode;
            $this->errMsg   = $e->errMsg;
            // 未知异常
        } else {
            //Config::get('app_debug');测试环境用原先tp5自带的异常处理机制
            if (config('app_debug') == true) {
                return parent::render($e);
            } else { //false 的时候是生产环境，交给日志来记录错误
                $this->httpCode = 500;
                $this->errCode  = 999;
                $this->errMsg   = '服务器内部错误不想告诉你';
                $this->recordLog($e->getMessage()); //服务器错误信息记录了日志
            }
        }

        $data = [
            'errCode'     => $this->errCode,
            'errMsg'      => $this->errMsg,
            'request_url' => Request::instance()->url()
        ];

        return json($data, $this->httpCode);

    }

    public function recordLog($content)
    {
        /*Log::init([ 'type'  => 'file',
            // 日志保存目录
            'path'  => LOG_PATH,
            // 日志记录级别
            'level' => ['error'],]);*/
        Log::record($content, 'error');
    }
}