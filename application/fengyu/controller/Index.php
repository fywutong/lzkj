<?php
namespace app\fengyu\controller;

use app\model\User;
use think\Controller;

class Index extends Controller
{
    public function console()
    {
       // $user=User::select();
        //print_r($user[0]['username']);die();
        return $this->fetch();
    }
    public function index()
    {
        $user=db('user')->select();
        return $this->fetch();
    }
    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
    
}
