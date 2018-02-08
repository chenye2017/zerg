<?php

namespace app\api\controller\v1;

use app\api\validate\AddressValidate;
use app\api\model\User as UserModel;
use app\api\model\UserAddress as UserAddressModel;
use app\lib\exception\SuccessMsg;
use think\Controller;
use think\Exception;
use think\Request;


class Address extends Controller
{
    public function createOrUpdate()
    {
        $validate = new AddressValidate();
        $validate->goCheck(); //验证参数

        $param = $validate->filterParam();

        //获取用户
        $userModel = new UserModel();
        $uid = $userModel->getUid();

        //这个用户的address是否存在，存在则更新，不存在则新建
        $userAddressModel = new UserAddressModel();
        $addressInfo = $userAddressModel::get(['user_id'=>$uid]);
        if ($addressInfo) {
            $ressult = $userAddressModel->save($param, ['user_id'=>$uid]);
        } else {
            $param['user_id'] = $uid;
            $ressult = $userAddressModel->create($param);
        }

        if (!$ressult) {
            throw new Exception('修改数据失败');
        } else {
            throw new SuccessMsg();
        }
    }
}
