<?php

namespace app\index\controller;

use app\model\Bidcreate as ModelBidcreate;
use app\model\Supplybid;
use Exception;
use think\Controller;

class Bidcreate extends Controller
{
    //采购商项目列表
    public function _empty()
    {
        $arr = ['msg' => '错误的方法', 'error' => 1];
        return json($arr);
    }
    public function bidcreatelist()
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
            $project_list = ModelBidcreate::withSearch(['userid'], ['userid' => $userid])
                ->where(function ($query) use ($data) {
                    $search = isset($data['examine']) ? $data['examine'] : '';
                    if ($search) {
                        $query->where('examine', '=', $search);
                    }
                })
                ->where(function ($query) use ($data) {
                    $search = isset($data['bname']) ? $data['bname'] : '';
                    if ($search) {
                        $query->where('bname', 'like', '%' . $search . '%');
                    }
                })
                ->where(function ($query) use ($data) {
                    $search = isset($data['timetype']) ? $data['timetype'] : '';
                    if ($search == 4) {
                        $query->where('time >' . date('Y-m-d') . ' or time is null');
                        $query->where('examine', '=', 1);
                    } else if ($search == 5) {
                        $query->where('time < ' . date('Y-m-d') . ' and examine = 1');
                    }
                })
                ->withAttr('mlist', function ($value) {
                    return json_decode($value, true);
                })->page($page, $number)->select();
                $count=count($project_list);
                $project_list['count']=$count;
                $project_list['page']=$page;
                $project_list['number']=$number;
            $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];
        } else {
            $arr = ['msg' => $returntoken['msg'], 'error' => 1];
        }
        return json($arr);
    }
    //采购项目添加
    public function bidcreateadd()
    {
        try {
            $project = new ModelBidcreate();
            $token = input('token');
            $returntoken = checkToken($token);
            $data = input();
            if (empty($token)) {
                $arr = ['msg' => 'token不能为空', 'error' => 1];
            } else if ($returntoken['code'] == 200) {
                $return = judgelogin($returntoken['data']['type']);
                if ($return['error'] == 1) {
                    return json($return);
                }
                $userid = $returntoken['data']['userid'];
                $data['userid'] = $userid;
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
            $arr = ['msg' => '必填项不能为空', 'error' => 1];
        }
        return json($arr);
    }
    //采购项目查看
    public function bidcreatecheck()
    {
        try {
          $id=input('id');
          $project_list = ModelBidcreate::get($id);
          $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];
        } catch (Exception $e) {
            $arr = ['msg' => '必填项不能为空', $e->getMessage(),'error' => 1];
        }
        return json($arr);
    }
    //采购项目修改
    public function bidcreateupdate()
    {
        try {
            $token = input('token');
            $returntoken = checkToken($token);
            $data = input();
            if (empty($token)) {
                $arr = ['msg' => 'token不能为空', 'error' => 1];
            } else if ($returntoken['code'] == 200) {
                $return = judgelogin($returntoken['data']['type']);
                if ($return['error'] == 1) {
                    return json($return);
                }
                $userid = $returntoken['data']['userid'];
                $data['userid'] = $userid;
                $category = input('category');
                $data['category'] = json_decode($category, true);
                $id = $data['id'];
                $project = ModelBidcreate::get($id);
                $save = $project->save($data);
                if ($save) {
                    $arr = ['msg' => '修改成功', 'error' => 0];
                } else {
                    $arr = ['msg' => '修改失败，异常错误', 'error' => 1];
                }
            } else {
                $arr = ['msg' => $returntoken['msg'], 'error' => 1];
            }
        } catch (Exception $e) {
            $arr = ['msg' => '必填项不能为空', 'error' => 1];
        }
        return json($arr);
    }
    //投标公告
    public function bidcreateall()
    {
        $page = input('page');
        $number = input('number');
        //print_r($action);die();
        $data=input();
        $project_list = ModelBidcreate::where('examine  =  2')
        ->withAttr('mlist', function ($value) {
            return json_decode($value, true);
        })->where(function ($query) use ($data) {
            $search = isset($data['bname']) ? $data['bname'] : '';
            if ($search) {
                $query->where('bname', 'like', '%' . $search . '%');
            }
        })->page($page, $number)->select();
        $count=count($project_list);
        $project_list['count']=$count;
        $project_list['page']=$page;
        $project_list['number']=$number;
        $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];
        return json($arr);
    }
    //供应商添加投标
    public function supplybidadd()
    {   
        
        try {
            $project = new Supplybid();
            $token = input('token');
            $returntoken = checkToken($token);
            $data = input();
            if (empty($token)) {
                $arr = ['msg' => 'token不能为空', 'error' => 1];
            } else if ($returntoken['code'] == 200) {
                $return = gongyinglogin($returntoken['data']['type']);
                if ($return['error'] == 1) {
                    return json($return);
                }
                $userid = $returntoken['data']['userid'];
                $detailedlistarr=[[
                    'name'=>'测试物资名称',
                    'model'=>'测试型号',
                    'parameter'=>'参数指标',
                    'brand'=>'品牌',
                    'address'=>'产地',
                    'unit'=>'单位',
                    'num'=>'5',
                    'shuiprice'=>'10',
                    'price'=>'8',
                    'taxprice'=>'2',
                    'remarks'=>'备注'
                ],[
                    'name'=>'测试物资名称',
                    'model'=>'测试型号',
                    'parameter'=>'参数指标',
                    'brand'=>'品牌',
                    'address'=>'产地',
                    'unit'=>'单位',
                    'num'=>'5',
                    'shuiprice'=>'10',
                    'price'=>'8',
                    'taxprice'=>'2',
                    'remarks'=>'备注'
                ]];
                 $data['pricelist']=json_encode($detailedlistarr);
                // print_r($data['detailedlist']);die();
                $data['sid'] = $userid;
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
            $arr = ['msg' => '必填项不能为空', 'error' => 1];
        }
        return json($arr);
    }   
    public function supplybidlist()
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
            $project_list = Supplybid::withSearch(['sid'], ['sid' => $userid])
                ->where(function ($query) use ($data) {
                    $search = isset($data['examine']) ? $data['examine'] : '';
                    if ($search) {
                        $query->where('examine', '=', $search);
                    }
                })
                ->where(function ($query) use ($data) {
                    $search = isset($data['bname']) ? $data['bname'] : '';
                    if ($search) {
                        $query->where('bname', 'like', '%' . $search . '%');
                    }
                })
                ->where(function ($query) use ($data) {
                    $search = isset($data['timetype']) ? $data['timetype'] : '';
                    if ($search == 4) {
                        $query->where('time >' . date('Y-m-d') . ' or time is null');
                        $query->where('examine', '=', 1);
                    } else if ($search == 5) {
                        $query->where('time < ' . date('Y-m-d') . ' and examine = 1');
                    }
                })
                ->withAttr('pricelist', function ($value) {
                    return json_decode($value, true);
                })->page($page, $number)->select();
                $count=count($project_list);
                $project_list['count']=$count;
                $project_list['page']=$page;
                $project_list['number']=$number;
            $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];
        } else {
            $arr = ['msg' => $returntoken['msg'], 'error' => 1];
        }
        return json($arr);
    }
   //http://lzjh.com/Index/bidcreate/supplybidlist?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2Mzc2Njk2MzksIm5iZiI6MTYzNzA2NDgzOSwiaWF0IjoxNjM3MDY0ODM5LCJ1c2VyaWQiOjEsInR5cGUiOiIxIiwidXNlcm5hbWUiOiJhZG1pbiJ9.k8SJUyovJs-qY6X1OX-_8yLmWY4HmvAUQMIqA1jpYHs&bid=1&iid=1&invoice=普通发票&tax=2&freight=1&other=1&name=李先生&tel=13888888888&remake=12312312313
}
