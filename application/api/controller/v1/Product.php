<?php

namespace app\api\controller\v1;

use app\api\validate\Count;
use app\api\validate\IdMustInt;
use think\Controller;
use think\Request;
use app\api\model\Product as ProductModel;

class Product extends Controller
{
    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        $productModel = new ProductModel();
        $products = $productModel->getRecent($count);

        //转换成数据集
        //$collection = collection($products);
        $products = $products->hidden(['summary']);

        return json($products);
    }

    public function getAllInCategory(Request $req)
    {
        (new IdMustInt())->goCheck();
        $productModel = new ProductModel();
        $products = $productModel->getAllInCategory($req->param('id'));
        return json($products);
    }


}
