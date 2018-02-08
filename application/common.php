<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//请求外部api
function my_curl($url, $data)
{
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);

     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_POST, 1);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     $result = curl_exec($ch);
     curl_close($ch);
     return $result;
}

//获取缓存中的值
function getCacheValue($token, $name)
{
    $arr = \think\Cache::get($token);
    if (!$arr) {
        throw new \app\lib\exception\ParamErrorException(
          ['msg'=>'token不存在或者错误']
        );
    }

    if (array_key_exists($name, $arr)) {
        return $arr[$name];
    } else {
        throw new Exception('缓存中不存在');
    }

}
