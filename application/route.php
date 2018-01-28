<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;  //使用自己动态注册的路由时候必须引入的类，配置式的直接返回一个数组就可以了
/*return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];*/

Route::rule('hello', 'text/hello/index', 'get|post', ['https'=>false]);

//Route::get('tp','index/index/index'); //快捷方式设置访问类型

Route::post('test', 'text/Hello/test');


Route::rule('test/:id/:name', 'test/test/test', 'get');


//rule是自定义的路由访问，就是人工输入的访问路径。route是原生的pathinfo对应的路径，rule是为了符合restful而设计的
//现有rule,才有route
Route::get('api/:version/banner/[:id]', 'api/:version.Banner/getBanner');

Route::get('api/:version/theme', 'api/:version.Theme/getSimpleList');