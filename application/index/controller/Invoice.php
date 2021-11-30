<?php

namespace app\index\controller;

use app\model\Invoice as InvoiceModel;
use Exception;
use think\Controller;
header("Access-Control-Allow-Origin: *");
class Invoice extends Controller
{
    //采购商项目列表
    public function _empty()
    {
        $arr = ['msg' => '错误的方法', 'error' => 1];
        return json($arr);
    }
    //订单列表
    public function instocklist()
    {
        $token = input('token');
        $page = input('page');
        $number = input('number');
        $returntoken = checkToken($token);
        $data = input();
        //print_r($action);die();
        if (empty($token)) {
            $arr = ['msg' => 'token不能为空', 'error' => 1];
        } else if ($returntoken['code'] == 200) {
            $return = judgelogin($returntoken['data']['type']);
            if ($return['error'] == 1) {
                return json($return);
            }
            $userid = $returntoken['data']['userid'];
            $project_list = InvoiceModel::where('purchaseid =' .$userid)
                ->withAttr('orderlist', function ($value) {
                    return json_decode($value, true);
                })->where(function ($query) use ($data) {
                    $search = isset($data['examine']) ? $data['examine'] : '';
                    if ($search) {
                        $query->where('examine = '.$search);
                    } 
                })->page($page, $number)->select();
            foreach($project_list as $k=>$v)
            {
                $contractid=$v['contractid'];
                if($v['type'] == 1 )
                {
                    $contractfind=db('contract')->find($contractid);
                }else
                {
                    $orderfind=db('order')->find($contractid);
                    $contractfind=db('contract')->find($orderfind['contractid']);
                }
                $contractfind=db('contract')->find($contractid);
                $project_list[$k]['projectname']=$contractfind['projectname'];
                $project_list[$k]['number']=$contractfind['number'];
                $project_list[$k]['supplyname']=$contractfind['supplyname'];
            }
            $count = count($project_list);
            $project_list['count'] = $count;
            $project_list['page'] = $page;
            $project_list['number'] = $number;
            $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];
        } else {
            $arr = ['msg' => $returntoken['msg'], 'error' => 1];
        }
        return json($arr);
    }
    //新增订单
    public function instockadd()
    {
        try {
            $project = new InvoiceModel();
            $token = input('token');
            $returntoken = checkToken($token);
            $data = input();
            if (empty($token)) {
                $arr = ['msg' => 'token不能为空', 'error' => 1];
            } elseif ($returntoken['code'] == 200) {
                $return = judgelogin($returntoken['data']['type']);
                if ($return['error'] == 1) {
                    return json($return);
                }
                $userid = $returntoken['data']['userid'];
                $contractid =  $data['contractid'];
                $data['purchaseid'] = $userid;
                $data['ordertime'] = date('Y-m-d');
                $contractfind=db('contract')->find($contractid);
                $data['supplyid']=$contractfind['supplyid'];
                $data['ddh']=time().rand('1111,9999');
                $save = $project->save($data);
                if ($save) {
                    $arr = ['msg' => '添加成功', 'error' => 0];
                } else {
                    $arr = ['msg' => '添加失败，异常错误', 'error' => 1];
                }
            } else {
                $arr = ['msg' => $returntoken['msg'], 'error' => 1];
            }
        } catch (Exception $e) {
            $arr = ['msg' => '必填项不能为空', 'xinxi' => $e->getMessage(), 'error' => 1];
        }
        return json($arr);
    }
    public function instockcheck()
    {
        try {
            $id = input('id');
            $project_list = InvoiceModel::get($id);
            $contractid=$project_list['contractid'];
            $contractfind=db('contract')->find($contractid);
            $project_list['projectname']=$contractfind['projectname'];
            $project_list['number']=$contractfind['number'];
            $project_list['supplyname']=$contractfind['supplyname'];
            $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];
        } catch (Exception $e) {
            $arr = ['msg' => '必填项不能为空', $e->getMessage(), 'error' => 1];
        }
        return json($arr);
    }
    //供应商订单列表
    public function sinstocklist()
    {
        $token = input('token');
        $page = input('page');
        $number = input('number');
        $returntoken = checkToken($token);
        $data = input();
        //print_r($action);die();
        if (empty($token)) {
            $arr = ['msg' => 'token不能为空', 'error' => 1];
        } else if ($returntoken['code'] == 200) {
            $return = gongyinglogin($returntoken['data']['type']);
            if ($return['error'] == 1) {
                return json($return);
            }
            $userid = $returntoken['data']['userid'];
            $project_list = InvoiceModel::where('purchaseid =' .$userid)
                ->withAttr('orderlist', function ($value) {
                    return json_decode($value, true);
                })->where(function ($query) use ($data) {
                    $search = isset($data['examine']) ? $data['examine'] : '';
                    if ($search) {
                        $query->where('examine = '.$search);
                    } 
                })->page($page, $number)->select();
            foreach($project_list as $k=>$v)
            {
                $contractid=$v['contractid'];
                if($v['type'] == 1 )
                {
                    $contractfind=db('contract')->find($contractid);
                }else
                {
                    $orderfind=db('order')->find($contractid);
                    $contractfind=db('contract')->find($orderfind['contractid']);
                }
                $project_list[$k]['projectname']=$contractfind['projectname'];
                $project_list[$k]['number']=$contractfind['number'];
                $project_list[$k]['supplyname']=$contractfind['supplyname'];
            }
            $count = count($project_list);
            $project_list['count'] = $count;
            $project_list['page'] = $page;
            $project_list['number'] = $number;
            $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];
        } else {
            $arr = ['msg' => $returntoken['msg'], 'error' => 1];
        }
        return json($arr);
    }
    //http://lzjh.com/Index/bidcreate/supplybidlist?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2Mzc2Njk2MzksIm5iZiI6MTYzNzA2NDgzOSwiaWF0IjoxNjM3MDY0ODM5LCJ1c2VyaWQiOjEsInR5cGUiOiIxIiwidXNlcm5hbWUiOiJhZG1pbiJ9.k8SJUyovJs-qY6X1OX-_8yLmWY4HmvAUQMIqA1jpYHs&bid=1&iid=1&invoice=普通发票&tax=2&freight=1&other=1&name=李先生&tel=13888888888&remake=12312312313
}
