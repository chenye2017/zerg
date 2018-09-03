<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2018/8/31
 * Time: 14:21
 */

namespace app\api\controller\v1;


use app\api\controller\Base;
use app\api\model\UserAddress;
use app\api\model\Product;
use app\api\model\Order as OrderModel;
use app\api\service\UserToken;
use app\api\validate\IdMustInt;
use app\api\validate\TestValidate;
use app\lib\exception\ForbiddenException;
use app\lib\exception\ParamErrorException;
use think\Exception;
use think\Request;
use think\Db;

class Order extends Base
{
    protected $beforeActionList = [
        'checkUserScope' => ['only' => 'placeOrder,getOrderInfo']
    ];

    /**
     * 下单主体函数
     * @return array
     * @throws Exception
     * @throws ParamErrorException
     * @throws \think\exception\DbException
     */
    public function placeOrder()
    {
        /*$validate = new OrderValidate();
        $validate->goCheck();*/
        //查看库存量够不够
        $produts = Request::instance()->param('products/a');
        $result  = $this->checkProduct($produts);

        // 订单失败，这个直接返回给用户错误信息就好了，都不能算下单了
        if (!$result['pass']) {
            return json([
                'code' => '',
                'data' => $result
            ], 400);
        }

        // 订单成功
        $orderNum = $this->generateOrderNum();
        // 订单封面 和 名称
        $firstProduct = Product::get($produts[0]['product']);
        $mainImg      = $firstProduct->main_img_url;
        $produtName   = $firstProduct->name;
        if (count($produts) > 1) {
            $produtName .= ' 等';
        }
        //订单地址
        $address = UserAddress::get(['user_id' => UserToken::getUid()]);

        Db::startTrans();
        try {

            $saveData = [
                'order_no'     => $orderNum,
                'user_id'      => UserToken::getUid(),
                'total_price'  => $result['orderPrice'],
                'snap_img'     => $mainImg,
                'snap_name'    => $produtName,
                'snap_items'   => json_encode($result),
                'snap_address' => json_encode($address),
                'total_count' => $result['totalCount']
            ];

            $order = new OrderModel($saveData);
            $order->save();

            $orderProductData = [];
            foreach ($produts as $p_value) {
                array_push($orderProductData, [

                    'product_id' => $p_value['product'],
                    'count'      => $p_value['count']
                ]);
            }

            //$orderProduct = new OrderProduct($orderProductData);
            //$orderProduct->save();
            $order->haveProducts()->saveAll($orderProductData);

            $result['order_id'] = $orderNum;
            $result['snap_img'] = $mainImg;
            $result['snap_name'] = $produtName;
            $result['snap_address'] = $address;

            Db::commit();
        } catch (Exception $e) {
            Db::rollback();
            throw new Exception($e->getMessage().' 添加订单失败');
        }

        return json([
            'code' => '',
            'data' => $result
        ], 200);
    }

    /**
     * 判断是否能成功下单
     * @param $products
     * @return array
     * @throws \think\exception\DbException
     */
    public function checkProduct($products)
    {
        $productId = [];
        foreach ($products as $p_key => $p_value) {
            array_push($productId, $p_value['product']);
        }
        $allProducts = Product::all($productId)->toArray();

        $generateOrder = $this->generateOrder($products, $allProducts);

        return $generateOrder;


    }

    /**
     * 组装前期下单参数
     * @param $products
     * @param $allProducts
     * @return array
     */
    public function generateOrder($products, $allProducts)
    {
        $pass       = true;
        $orderPrice = 0;
        $totalCount = 0;
        $pstatusArr = [];

        foreach ($products as $p_key => $p_value) {

            $totalCount += $p_value['count'];

            $productId = $p_value['product'];
            $exist     = false;
            foreach ($allProducts as $a_key => $a_value) {
                if ($a_value['id'] == $productId) {
                    $exist = true;

                    $orderPrice += $p_value['count'] * $a_value['price'];

                    if ($p_value['count'] > $a_value['stock']) {
                        array_push($pstatusArr, [
                            'count'      => $p_value['count'],
                            'haveStock'  => false,
                            'id'         => $a_value['id'],
                            'name'       => $a_value['name'],
                            'totalPrice' => $p_value['count'] * $a_value['price']
                        ]);
                        $pass = false;
                    } else {
                        array_push($pstatusArr, [
                            'count'      => $p_value['count'],
                            'haveStock'  => true,
                            'id'         => $a_value['id'],
                            'name'       => $a_value['name'],
                            'totalPrice' => $p_value['count'] * $a_value['price']
                        ]);
                    }


                }
            }
            if (!$exist) {
                array_push($pstatusArr, ['product' => $productId, 'count' => $p_value['count'], 'haveStock' => false]);
                $pass = false;
            }
        }

        return [
            'pass'       => $pass,
            'orderPrice' => $orderPrice,
            'totalCount' => $totalCount,
            'pstatusArr' => $pstatusArr
        ];
    }

    public function generateOrderNum()
    {
        $yCode   = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }


    /**
     * 获取订单详情
     * @return array
     * @throws ForbiddenException
     * @throws ParamErrorException
     */
    public function getOrderInfo()
    {
        (new IdMustInt())->goCheck(); // 这种命名方式相比较我那种在命名中加入模块名称的通用性更高
        // 验证订单是不是你的
        $userid = UserToken::getUid();
        $id = Request::instance()->route('id');
        $orderInfo = OrderModel::where('user_id', '=', $userid)->where('id', '=', $id)->select();
        if ($orderInfo->isEmpty()) {
            throw new ForbiddenException();
        }
        return json(['code'=>'', 'data'=>$orderInfo]);

    }

    /**
     * 获取每页订单大概信息
     * @return \think\response\Json
     * @throws ParamErrorException
     * @throws \think\exception\DbException
     */
    public function getSelfOrders()
    {
        $page = Request::instance()->param('page', 1);
        $limit = Request::instance()->param('limit', 5);

        $order = Db::table('order')->where('user_id', '=', UserToken::getUid())->order('id', 'desc')->paginate($limit, true, ['page'=>$page])->toArray();

        return json(['code'=>'', 'data'=>$order]);
    }

    public function test(Request $req)
    {
        //var_dump($req->param('test'));exit;
        //var_dump($_POST['test']);
        //var_dump($_POST, $_POST['test']);exit;
        //var_dump(Request::instance()->param());exit;
        $z = Request::instance()->param();
        var_dump($z);
        exit;
        (new TestValidate())->goCheck();
        var_dump('ll');
        exit;
    }
}