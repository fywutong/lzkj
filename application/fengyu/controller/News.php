<?php
namespace app\fengyu\controller;

use app\model\News as Newsmodel;
use think\Controller;

class News extends Controller
{
    public function console()
    {
       // $user=User::select();
        //print_r($user[0]['username']);die();
        return $this->fetch();
    }
    public function index()
    {
        $news_list=Newsmodel::select()->order('id desc');
        //$user=db('user')->select();
        $this->assign("news_list",$news_list);
        return $this->fetch();
    }
    //练习用的方法 
    public function jiangyi()
    {
        // Db::raw('price - 3') 字段增减值或者直接用SQL方法
        //Db::name('user')->whereTime('create_time','d')->select();//查询当天或者查询昨天
        //page(1,5)->select();page(2,5)->select();//分页方法
    }
}
