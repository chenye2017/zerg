<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/27
 * Time: 20:08
 */

namespace app\api\model;


use think\Db;
use think\Model;

class Banner extends Model
{
    protected $table = 'banner_item';
    public static function getBannerById($id)
    {
        //try {
            //1/0;
        //} catch (Exception $e) {
            //throw $e;
        //}
        $banner = Db::query('select * from banner_item ', []);
        //$banner = Db::table('banner_item')->find();

        return $banner;
    }
}