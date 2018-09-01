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
        $products     = $productModel->getRecent($count);//var_dump($products);exit;

        //转换成数据集
        //$collection = collection($products);
        //var_dump($collection);exit;
        $products = $products->hidden(['summary']);

        return json($products);
    }

    /**
     * 根据category id 获取这个分类下商品的详细情况
     * @param Request $req
     * @return \think\response\Json
     * @throws \app\lib\exception\ParamErrorException
     * @throws \app\lib\exception\ProductException
     */
    public function getAllInCategory($id)
    {
        (new IdMustInt())->goCheck();
        $productModel = new ProductModel();
        $products     = $productModel->getAllInCategory($id);
        return json($products);
    }

    /**
     * 获取一个商品的详细信息
     * @param $id
     * @return \think\response\Json
     */
    public function getOne($id)
    {
        (new IdMustInt())->goCheck();
        $productModel = new ProductModel();
        $product      = $productModel->getOne($id);
        return json($product);
    }


}
