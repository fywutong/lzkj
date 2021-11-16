<?php

namespace app\index\controller;


use think\Controller;

class Error
{
  public function _empty()
  {
    $arr = ['msg' => '错误的方法', 'error' => 1];
    return json($arr);
  }
   
}
