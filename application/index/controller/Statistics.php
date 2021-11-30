<?php

namespace app\index\controller;

use think\Controller;
header("Access-Control-Allow-Origin: *");
class Statistics extends Controller
{
    public function _empty()
    {
        $arr = ['msg' => '错误的方法', 'error' => 1];
        return json($arr);
    }
    //上传图片
    public function overview()
    {
        $token = input('token');
        
    }
}
