<?php

namespace app\api\controller\v1;

use app\api\controller\Base;
use app\api\service\UserToken;
use app\api\validate\AddressValidate;
use app\api\model\User as UserModel;
use app\api\model\UserAddress as UserAddressModel;
use app\lib\enum\UserScope;
use app\lib\exception\SuccessMsg;
use app\lib\exception\ForbiddenException;
use think\Controller;
use think\Request;


class Address extends Base
{
    public $beforeActionList = [
        'checkUserScope' => ['only'=>'createOrUpdate']
    ];

    public function createOrUpdate()
    {
        $validate = new AddressValidate();
        $validate->goCheck(); //验证参数


        $param = $validate->filterParam();

        //获取用户
        $userToken = new UserToken();
        $uid = $userToken->getUid();

        //这个用户的address是否存在，存在则更新，不存在则新建
        $userAddressModel = new UserAddressModel();
        // 目前是1 对 1
        $addressInfo = $userAddressModel::get(['user_id'=>$uid]);
        if ($addressInfo) {
            $ressult = $userAddressModel->save($param, ['user_id'=>$uid]);//这个数据没有变动会修改也是返回0

        } else {
            $param['user_id'] = $uid;
            $ressult = $userAddressModel->create($param);
        }
           throw new SuccessMsg();
    }


    public function first()
    {
        var_dump('first');
    }

    public function second()
    {
        var_dump('second');
    }

    public function third()
    {
        var_dump('third');
    }

}
