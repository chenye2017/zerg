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
use think\Exception;
use app\lib\exception\BannerMissingException;


class Banner extends Model
{
    protected $hidden = ['update_time', 'delete_time']; //定义一些通用的隐藏的字段
    // protected $table = 'banner_item';
    //public static function getBannerById($id)
    //{
        //$a = 0;
        /*try {
            1/0;
        }
        catch (Exception $e) {
            echo 'll';
            throw $e;
        }*/
        //$banner = Db::query('select * from banner_item where banner_id = ?', [$id]);
        //$banner = Db::table('banner_item')->find();

        //$banner = Db::table('banner_item')
            //->where('banner_id', '=', $id)
            //->fetchSql()
            //->select();

        //return $banner;
    //}

    public function getBannerById($id)
    {
        $banner = $this->with(['items', 'items.img'])->find($id);

        if (!$banner) {
            throw new BannerMissingException();
        }

        return $banner;
    }

    public function items()
    {
        $items = $this->hasMany('BannerItem', 'banner_id', 'id');
        return $items;
    }
}