<?php

namespace app\api\controller\v1;

use app\api\model\User;
use app\api\model\UserAddress;
use think\Controller;
use think\Request;
use app\api\model\Category as CategoryModel;

class Category extends Controller
{
    public function getAllCategory()
    {
        //var_dump(User::with(['withUserAddress'])->select()->toArray());exit;
        //var_dump(UserAddress::with(['withUser'])->select()->toArray());exit;
        //var_dump(UserAddress::with(['withUser1'])->select()->toArray());exit;
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategory();
        return json($categories);
    }
}
