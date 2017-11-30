<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/26
 * Time: 18:41
 */

namespace app\api\controller\v1;


use app\api\model\Banner as BannnerModel;
use app\api\validate\IdMustInt;
use app\lib\exception\BannerMissingException;
use think\Request;

class Banner
{
    public function getBanner(Request $request)
    {
        //$z = 1/0; return;
        /*$param  = [
            'id' => -1,
            'email' => '1967196626qq.com'
        ];*/


        /*$validate = new Validate([
            'id' => 'require|max 1',  //这个就相当于 自定义的$rule最后拼在一起了，用的话这个id感觉不要定义在那里面比较好，否则以后只能用这个参数名
            'email' => 'email'
        ]);*/
        $validate = new IdMustInt();
        $id = $request->param('id');
        $result = $validate->goCheck();
        //var_dump($result);exit;
        //var_dump($validate->getError());
        //try {
            //$bannner = BannnerModel::getBannerById($id);
        $bannner = BannnerModel::get($id); //这个还必须传递id，否则会报错
            if (!$bannner) {
                throw new BannerMissingException();
            }
       // } catch (Exception $e) {
            $result = ['errCode'=>1001,'errMsg'=>'出错啦'];
           // return json($result, 400);
        //}
        return $bannner;

    }
}