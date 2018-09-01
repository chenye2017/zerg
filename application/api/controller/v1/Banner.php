<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/26
 * Time: 18:41
 */

namespace app\api\controller\v1;


use app\api\model\Banner as BannerModel;
use app\api\validate\BaseValidate;
use app\api\validate\IdMustInt;

use think\Request;
use think\Validate;


class Banner
{
    /**
     * 获取具体的banner信息
     * @http:Get
     * @param Request $request
     * @param id  banner的id
     * @return null|static
     * @throws BannerMissingException
     */
    public function getBanner(Request $request)
    {

        //$z = 1/0; return;
        /*$param  = [
            'id' => 8,
            'email' => '1967196626qq.com'
        ];*/

        //$param = $request->params();
        //$id = $param['id'];
        $id = $request->param('id');
        //$id = input('get.id');
        /*$validate = new Validate([
            'id' => 'require|max 1',  //这个就相当于 自定义的$rule最后拼在一起了，用的话这个id感觉不要定义在那里面比较好，否则以后只能用这个参数名
            'email' => 'email'
        ]);*/
        $validate = new IdMustInt();
        $check    = $validate->goCheck();

//exit;
        //} else {
        //$id = $request->param('id');
        //$result = $validate->batch()->check($param);
        //var_dump($validate->getError());
        //$a = 1;
        //var_dump($result);exit;
        //var_dump($validate->getError());
        //try {
        //$bannner = BannnerModel::getBannerById($id);

        //$banner = BannerModel::with(['items', 'items.img'])->find($id); //这个还必须传递id，否则会报错

        /*$bannerModel = new BannerModel();
        $banner = $bannerModel->hasMany('BannerItem', 'banner_id', 'id')->find($id);
        $banner = $bannerModel->getBannerById($id);*/
        $bannerModel = new BannerModel();
        $banner = $bannerModel->with(['items', 'items.img'])->find($id);

        $banner->hidden(['update_time', 'delete_time']);
        /*if (!$banner) {
            throw new BannerMissingException();
        }*/
        //}
        /*catch
            (Exception $e) {
                $result = ['errCode' => 1001, 'errMsg' => '出错啦'];
                return json($result, 400);
            }*/
        return json($banner);  //这种自动是吧返回json好神奇，不用修改config里面返回的文件类型
    }

    public function test()
    {

    }

}