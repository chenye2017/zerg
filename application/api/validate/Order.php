<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2018/8/31
 * Time: 14:22
 */

namespace app\api\validate;


use app\lib\exception\ProductsException;

class Order extends BaseValidate
{
    protected $rule = [
        'products' => 'checkProducts'
    ];

    protected $checkProducts = [
        'product' => 'required|idMustInt',
        'count' => 'required|idMustInt'
    ];

    public function checkProducts($value)
    {
        if (!is_array($value)) {
            throw new ProductsException();
        }

        foreach ($value as $k_value) {
            $validate = new BaseValidate($this->checkProducts);
            $res = $validate->check($k_value);
            if (!$res) {
                return false;
            }
        }

        return true;
    }
}