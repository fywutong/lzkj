<?php

namespace app\index\controller;

use app\model\Project as ProjectModel;
use app\model\User;
use think\Controller;
header("Access-Control-Allow-Origin: *");
class Uploads extends Controller
{
    public function _empty()
    {
        $arr = ['msg' => '错误的方法', 'error' => 1];
        return json($arr);
    }
    //上传图片
    public function uploads()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move('../public/static/uploads');
        if ($info) {
     
            $getSaveName=str_replace("\\","/",$info->getSaveName());
            $arr = ['msg' => '上传成功','images'=>$getSaveName,'error' => 0];
        } else {
            $arr = ['msg' => $file->getError(), 'error' => 1];
        }
        return json($arr);
    }
}
