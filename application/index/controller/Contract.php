<?php

namespace app\index\controller;

use app\model\Contract as ContractModel;
use app\model\Supplybid;
use Exception;
use think\Controller;
header("Access-Control-Allow-Origin: *");
class Contract extends Controller
{
    //采购商项目列表
    public function _empty()
    {
        $arr = ['msg' => '错误的方法', 'error' => 1];
        return json($arr);
    }
    //合同待录入列表
    public function contractwaitlist()
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
            $project_list = Supplybid::where('purchaseid =' .$userid)
                ->where('winbid = 2')
                ->withAttr('pricelist', function ($value) {
                    return json_decode($value, true);
                })->append(['bname','bcname','bmode','endtime','calibrationtime'])->page($page, $number)->select();
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
    //合同录入
    public function contractadd()
    {
        try {
            $project = new ContractModel();
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
            //     $detailedlistarr=array(
            //         'zprice'=>array('dxprice'=>'大写总金额','xxprice'=>'小写总金额'),
            //         'data'=>array([
            //             'name'=>'测试物资名称',
            //             'model'=>'测试型号',
            //             'parameter'=>'参数指标',
            //             'brand'=>'品牌',
            //             'address'=>'产地',
            //             'unit'=>'单位',
            //             'num'=>'5',
            //             'remarks'=>'备注'
            //         ],[
            //             'name'=>'测试物资名称',
            //             'model'=>'测试型号',
            //             'parameter'=>'参数指标',
            //             'brand'=>'品牌',
            //             'address'=>'产地',
            //             'unit'=>'单位',
            //             'num'=>'5',
            //             'remarks'=>'备注'
            //         ],[
            //             'name'=>'测试物资名称',
            //             'model'=>'测试型号',
            //             'parameter'=>'参数指标',
            //             'brand'=>'品牌',
            //             'address'=>'产地',
            //             'unit'=>'单位',
            //             'num'=>'5',
            //             'remarks'=>'备注'
            //         ])
            //    );
            //     return json($detailedlistarr);die();
                // $data['detailedlist']=json_encode($detailedlistarr);
                $data['purchaseid'] = $userid;
                //print_r($data);die();
                $save = $project->save($data);
                if ($save) {
                    $tjarr['contractid']=$save;
                    $tjarr['id']=$data['listid'];
                    db('supplybid')->update($tjarr);
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
    //录入合同列表
    public function contractlist()
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
            $project_list = ContractModel::where('purchaseid  =' .$userid)
                ->withAttr('bidlist', function ($value) {
                    return json_decode($value, true);
                })->where(function ($query) use ($data) {
                    $search = isset($data['state']) ? $data['state'] : '';
                    if ($search) {
                        $query->where('state = '.$search);
                    } 
                })->page($page, $number)->select();
            foreach($project_list as $k=>$v)
            {
                //保证金
                $supplyid=$v['listid'];
                $supplyfind=db('supplybid')->find($supplyid);
                $bidfind=db('bidcreate')->find($supplyfind['bid']);
                $project_list[$k]['bondprice']=$bidfind['bondprice'];
                $project_list[$k]['calibrationtime']=$bidfind['calibrationtime'];
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
    public function scontractlist()
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
            $project_list = ContractModel::where('purchaseid  =' .$userid)
                ->withAttr('bidlist', function ($value) {
                    return json_decode($value, true);
                })->where(function ($query) use ($data) {
                    $search = isset($data['state']) ? $data['state'] : '';
                    if ($search) {
                        $query->where('state = '.$search);
                    } 
                })->page($page, $number)->select();
            foreach($project_list as $k=>$v)
            {
                //保证金
                $bid=$v['bid'];
                $bidfind=db('bidcreate')->find($bid);
                $project_list[$k]['bondprice']=$bidfind['bondprice'];
                $project_list[$k]['calibrationtime']=$bidfind['calibrationtime'];
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
    public function contractcheck()
    {
        try {
            $id = input('id');
            $project_list = ContractModel::get($id);
            $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];
        } catch (Exception $e) {
            $arr = ['msg' => '必填项不能为空', $e->getMessage(), 'error' => 1];
        }
        return json($arr);
    }
    
    //http://lzjh.com/Index/bidcreate/supplybidlist?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2Mzc2Njk2MzksIm5iZiI6MTYzNzA2NDgzOSwiaWF0IjoxNjM3MDY0ODM5LCJ1c2VyaWQiOjEsInR5cGUiOiIxIiwidXNlcm5hbWUiOiJhZG1pbiJ9.k8SJUyovJs-qY6X1OX-_8yLmWY4HmvAUQMIqA1jpYHs&bid=1&iid=1&invoice=普通发票&tax=2&freight=1&other=1&name=李先生&tel=13888888888&remake=12312312313
}
