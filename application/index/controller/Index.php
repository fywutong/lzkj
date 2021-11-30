<?php

namespace app\index\controller;

use app\model\Project;
use app\model\User;
use think\Controller;
header("Access-Control-Allow-Origin: *");
class Index extends Controller
{
    public function _empty()
    {
        $arr = ['msg' => '错误的方法', 'error' => 1];
        return json($arr);
    }
    public function csmodel()
    {
        $user = User::select();
        //print_r($user[0]['username']);die();
        return json($user);
    }
    public function index()
    {
        return $this->fetch();
    }
    public function hello($name = 'ThinkPHP5')
    {
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzb2wiLCJleHAiOjE2MzU0OTMyNjcsImF1ZCI6ImFkbWluIiwibmJmIjoxNjM0ODg4NDY3LCJpYXQiOjE2MzQ4ODg0NjcsImFkbWluX2lkIjo2NjYsImFkbWluIjp0cnVlfQ.DdMXNGKSxpEXSBL12TA0qFC-vgwSWVIENRPCOuXLkdg";
        $return = checkToken($token);
        return $return;
    }
    //登录
    public function login()
    {
        $username = input('username');
        $password = md5(input('password'));
        $type = input('type');
        $where = ['username' => $username, 'password' => $password, 'type' => $type];
        $loginfind = User::where($where)->find();
        if ($loginfind) {
            $userid = $loginfind['id'];
            $token = createToken($userid, $username, $type);
            $arr = ['msg' => '登录成功', 'error' => 0, 'token' => $token];
        } else {
            $arr = ['msg' => '账号或密码错误', 'error' => 1];
        }
        return json($arr);
    }
    //注册
    public function register()
    {
        $user = new User();
        $savearr = input();
        $savearr['password'] = md5(input('password'));
        $username = input('username');
        $type = input('type');
        $where = ['username' => $username, 'type' => $type];
        $loginfind = User::where($where)->find();
        if (input('code') != 123456) {
            $arr = ['msg' => '验证码错误', 'error' => 1];
        } else if ($loginfind) {
            $arr = ['msg' => '此账号已经注册', 'error' => 1];
        } else {
            $add = $user->save($savearr);
            if ($add) {
                $arr = ['msg' => '注册成功', 'error' => 0];
            } else {
                $arr = ['msg' => '注册失败，异常错误', 'error' => 1];
            }
        }
        return json($arr);
    }
    //修改信息
    public function updateaccount()
    {
        //eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2MzU3MzM3MjAsIm5iZiI6MTYzNTEyODkyMCwiaWF0IjoxNjM1MTI4OTIwLCJ1c2VyaWQiOjMsInR5cGUiOiIxIiwidXNlcm5hbWUiOiIxMzg4ODg4ODg4OCJ9.n1qEdiqk4odO-vhUnUJv5wfcLkD9_ARi30t7xID2aBk
        $token = input('token');
        $savearr = input();
        $returntoken = checkToken($token);
        if (empty($token)) {
            $arr = ['msg' => 'token不能为空', 'error' => 1];
        } else if ($returntoken['code'] == 200) {
            $user = User::get($returntoken['data']['userid']);
            $save = $user->save($savearr);
            if ($save) {
                $arr = ['msg' => '修改成功', 'error' => 0];
            } else {
                $arr = ['msg' => '修改失败，异常错误', 'error' => 1];
            }
        } else {
            $arr = ['msg' => $returntoken['msg'], 'error' => 1];
        }
        return json($arr);
    }
    //修改手机号
    public function updatetel()
    {
        //eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2MzU3MzM3MjAsIm5iZiI6MTYzNTEyODkyMCwiaWF0IjoxNjM1MTI4OTIwLCJ1c2VyaWQiOjMsInR5cGUiOiIxIiwidXNlcm5hbWUiOiIxMzg4ODg4ODg4OCJ9.n1qEdiqk4odO-vhUnUJv5wfcLkD9_ARi30t7xID2aBk
        $token = input('token');
        $savearr = input();
        $returntoken = checkToken($token);
        if (empty($token)) {
            $arr = ['msg' => 'token不能为空', 'error' => 1];
        } else if ($returntoken['code'] == 200) {
            if (input('code') != 123456) {
                $arr = ['msg' => '验证码错误', 'error' => 1];
            } else {
                $user = User::get($returntoken['data']['userid']);
                $save = $user->save($savearr);
                if ($save) {
                    $arr = ['msg' => '修改成功', 'error' => 0];
                } else {
                    $arr = ['msg' => '修改失败，异常错误', 'error' => 1];
                }
            }
        } else {
            $arr = ['msg' => $returntoken['msg'], 'error' => 1];
        }
        return json($arr);
    }
    //修改密码
    public function updatepwd()
    {
        //eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2MzU3MzM3MjAsIm5iZiI6MTYzNTEyODkyMCwiaWF0IjoxNjM1MTI4OTIwLCJ1c2VyaWQiOjMsInR5cGUiOiIxIiwidXNlcm5hbWUiOiIxMzg4ODg4ODg4OCJ9.n1qEdiqk4odO-vhUnUJv5wfcLkD9_ARi30t7xID2aBk
        $token = input('token');
        $savearr = input();
        $returntoken = checkToken($token);
        if (empty($token)) {
            $arr = ['msg' => 'token不能为空', 'error' => 1];
        } else if ($returntoken['code'] == 200) {
            if (input('code') != 123456) {
                $arr = ['msg' => '验证码错误', 'error' => 1];
            } else {
                $user = User::get($returntoken['data']['userid']);
                $save = $user->save($savearr);
                if ($save) {
                    $arr = ['msg' => '修改成功', 'error' => 0];
                } else {
                    $arr = ['msg' => '修改失败，异常错误', 'error' => 1];
                }
            }
        } else {
            $arr = ['msg' => $returntoken['msg'], 'error' => 1];
        }
        return json($arr);
    }
    //eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2MzYzNTM2NjMsIm5iZiI6MTYzNTc0ODg2MywiaWF0IjoxNjM1NzQ4ODYzLCJ1c2VyaWQiOjMsInR5cGUiOiIyIiwidXNlcm5hbWUiOiIxMzg0MDQ2MzI4NSJ9.-ZX_PXzB1Es5HcRtKtdFcHXEzrNKOqTUB78zwoR_aY4
}
