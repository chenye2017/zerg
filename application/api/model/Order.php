<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2018/9/1
 * Time: 18:30
 */

namespace app\api\model;


use think\Model;

class Order extends Model
{
    protected $autoWriteTimestamp = true;

    public function haveProducts()
    {
        return $this->belongsToMany('\app\api\model\OrderProduct', 'order_product', 'order_id', 'id');
    }

    public function getSnapItemsAttr($value)
    {
        return json_decode($value, true);
    }

    public function getSnapAddressAttr($value)
    {
        return json_decode($value, true);
    }
}