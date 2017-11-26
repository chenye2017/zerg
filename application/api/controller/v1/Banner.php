<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/26
 * Time: 18:41
 */

namespace app\api\controller\v1;

use think\Validate;
use app\api\validate\IdMustInt;


class Banner
{
    public function getBanner()
    {
        /*$param  = [
            'id' => -1,
            'email' => '1967196626qq.com'
        ];*/


        /*$validate = new Validate([
            'id' => 'require|max 1',  //这个就相当于 自定义的$rule最后拼在一起了，用的话这个id感觉不要定义在那里面比较好，否则以后只能用这个参数名
            'email' => 'email'
        ]);*/
        $validate = new IdMustInt();

        $result = $validate->goCheck();
        //var_dump($result);exit;
        var_dump($validate->getError());

    }
}