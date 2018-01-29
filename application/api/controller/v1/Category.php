<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Request;
use app\api\model\Category as CategoryModel;

class Category extends Controller
{
    public function getAllCategory()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategory();
        return json($categories);
    }
}
