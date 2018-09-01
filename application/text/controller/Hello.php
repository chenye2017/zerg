<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/26
 * Time: 15:06
 */

namespace app\text\controller;

use think\Request;


class Hello
{
    public function index($name, $id, $body)
    {
        var_dump($name, $id, $body);
        exit;
        echo 'hello';
        //echo ;
        return;
    }

    public function test(Request $request)
    {
        var_dump($request->get());
        exit;
        //var_dump(Request::instance()->param());exit;
        $param = input('get');
        var_dump($param);
        exit;
        $id   = Request::instance()->get('id');
        $name = Request::instance()->get('name');
        echo $id . '!';
        echo $name;
        exit;
        //echo 'hello '.$name.' , 我的id是'.$id;
        echo $id;
        die;
    }
}