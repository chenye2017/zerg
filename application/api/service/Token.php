<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/2/6
 * Time: 23:14
 */

namespace app\api\service;


class Token
{
    public function generateToken($length)
    {
        $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789=[].,';
        $token = '';
        for ($i=0; $i<$length; $i++) {
            $rand = mt_rand(0,52);
            $token .= $string[$rand];
        }

        $timestamp = $_SERVER['REQUEST_TIME'];
        $salt = config('secure.token_salt');
        $token = md5($token.$timestamp.$salt);

        return $token;
    }
}