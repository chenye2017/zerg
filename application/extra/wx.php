<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/1/30
 * Time: 21:45
 */

return [
    'app_id'=>'wx3522a2aa118cdb25',
    'app_secret'=>'cf07578eb23de8d214061625c41a7eba',
    'get_token_url'=>'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',
    'token_expire_in'=>60 * 60 * 24 * 7 //token 有效期设置成1天，方便测试，这个token 不好用的话重新生成一个token就好了
];