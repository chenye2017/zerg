<?php

namespace app\api\controller\v1;

use app\api\validate\BaseValidate;
use app\api\validate\IdMustArray;
use app\api\validate\IdMustInt;
use think\Controller;
use think\Db;
use think\Request;
use app\api\model\Theme AS ThemeModel;

class Theme extends Controller
{
    /**
     * 根据id，获取展示的一组专题信息
     * @param Request $req
     * @return \think\response\Json
     */
    public function getSimpleList(Request $req)
    {
        $validate = new IdMustArray([]);
        $validate->goCheck();
        $themeModel = new ThemeModel();
        $ids = explode(',', $req->param('id'));
        $themes = $themeModel->getThemeByIds($ids);
        return json($themes);
    }

    /**
     * 获取一个主题的详细信息
     * @param Request $req
     * @return \think\response\Json
     */
    public function getComplexOne(Request $req)
    {
        (new IdMustInt())->goCheck();
        $themeModel = new ThemeModel();
        $theme = $themeModel->getThemeInfo($req->param('id'));
        return json($theme);
    }
}
