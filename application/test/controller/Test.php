<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/1/17
 * Time: 21:51
 */

namespace app\test\controller;


class Test
{
    public function test($name, $id, $city='shanghai')
    {
        echo 'hello '.$name.' , 编号'.$id.' 来到'.$city; //这种方式首先通过路由里面配置的获取参数。：后面的名称，如果没有，更具？后面的名称加上变量的名称
        //如果获取不到参数，会报错误的，所以给个默认值能防止错误信息，但感觉其实这个是由框架决定的吧，我们那个itbasic的框架就不会报错
        //echo 'hello cy';
    }
}