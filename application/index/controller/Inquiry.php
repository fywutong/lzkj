<?php

namespace app\index\controller;

use app\model\Inquiry as ModelInquiry;
use app\model\Offer;
use Exception;
use think\Controller;
header("Access-Control-Allow-Origin: *");
class Inquiry extends Controller
{
    //采购商项目列表
    public function _empty()
    {
        $arr = ['msg' => '错误的方法', 'error' => 1];
        return json($arr);
    }
    public function inquirylist()
    {
        $token = input('token');
        $page = input('page');
        $number = input('number');
        $returntoken = checkToken($token);
        $data = input();
        //print_r($action);die();
        if (empty($token)) {
            $arr = ['msg' => 'token不能为空', 'error' => 1];
        } elseif ($returntoken['code'] == 200) {
            $return = judgelogin($returntoken['data']['type']);
            if ($return['error'] == 1) {
                return json($return);
            }
            $userid = $returntoken['data']['userid'];
            $project_list = ModelInquiry::withSearch(['userid'], ['userid' => $userid])
                ->where(function ($query) use ($data) {
                    $search = isset($data['examine']) ? $data['examine'] : '';
                    if ($search) {
                        $query->where('examine', '=', $search);
                    }
                })
                ->where(function ($query) use ($data) {
                    $search = isset($data['name']) ? $data['name'] : '';
                    if ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    }
                })
                ->where(function ($query) use ($data) {
                    $search = isset($data['timetype']) ? $data['timetype'] : '';
                    if ($search == 4) {
                        $query->where('edate <' . date('Y-m-d') . ' and examine = 1');
                    } elseif ($search == 5) {
                        $query->where('edate > ' . date('Y-m-d') . ' and examine = 1');
                    }
                })
                ->withAttr('detailedlist', function ($value) {
                    return json_decode($value, true);
                })->page($page, $number)->order('id desc')->select();
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
    //采购项目添加
    public function inquiryadd()
    {
        // register_shutdown_function( 'close' );
        try {
            $project = new ModelInquiry();
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
                // $detailedlistarr=[[
                //     'name'=>'测试物资名称',
                //     'model'=>'测试型号',
                //     'parameter'=>'参数指标',
                //     'brand'=>'品牌',
                //     'address'=>'产地',
                //     'unit'=>'单位',
                //     'num'=>'5',
                //     'remarks'=>'备注'
                // ],[
                //     'name'=>'测试物资名称',
                //     'model'=>'测试型号',
                //     'parameter'=>'参数指标',
                //     'brand'=>'品牌',
                //     'address'=>'产地',
                //     'unit'=>'单位',
                //     'num'=>'5',
                //     'remarks'=>'备注'
                // ],[
                //     'name'=>'测试物资名称',
                //     'model'=>'测试型号',
                //     'parameter'=>'参数指标',
                //     'brand'=>'品牌',
                //     'address'=>'产地',
                //     'unit'=>'单位',
                //     'num'=>'5',
                //     'remarks'=>'备注'
                // ]];
                // $data['detailedlist']=json_encode($detailedlistarr);
                $data['userid'] = $userid;
                //print_r($data);die();
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
    public function inquirycheck()
    {
        try {
            $id = input('id');
            $project_list = ModelInquiry::get($id);
            $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];
        } catch (Exception $e) {
            $arr = ['msg' => '必填项不能为空', $e->getMessage(), 'error' => 1];
        }
        return json($arr);
    }
    //采购项目修改
    public function inquiryupdate()
    {
        try {
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
                $data['userid'] = $userid;
                $id = $data['id'];
                $project = ModelInquiry::get($id);
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
    //全部询价
    public function offerlist()
    {
        $page = input('page');
        $number = input('number');
        $data = input();
        $project_list = ModelInquiry::withAttr('detailedlist', function ($value) {
            return json_decode($value, true);
        })->where(function ($query) use ($data) {
            $search = isset($data['iname']) ? $data['iname'] : '';
            if ($search) {
                $query->where('iname', 'like', '%' . $search . '%');
            }
        })->where('examine = 2')->page($page, $number)->order('id desc')->select();
        $count = count($project_list);
        $project_list['count'] = $count;
        $project_list['page'] = $page;
        $project_list['number'] = $number;
        $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];
        return json($arr);
    }
    //开始报价
    public function offeradd()
    {
        try {
            $project = new Offer();
            $token = input('token');
            $returntoken = checkToken($token);
            $data = input();
            if (empty($token)) {
                $arr = ['msg' => 'token不能为空', 'error' => 1];
            } elseif ($returntoken['code'] == 200) {
                $return = gongyinglogin($returntoken['data']['type']);
                if ($return['error'] == 1) {
                    return json($return);
                }
                $userid = $returntoken['data']['userid'];
                $data['supplyid'] = $userid;
                //print_r($data);die();
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
    //所有询价
    public function offerall()
    {
        $token = input('token');
        $page = input('page');
        $number = input('number');
        $returntoken = checkToken($token);
        $data = input();
        //print_r($action);die();
        if (empty($token)) {
            $arr = ['msg' => 'token不能为空', 'error' => 1];
        } elseif ($returntoken['code'] == 200) {
            $return = gongyinglogin($returntoken['data']['type']);
            if ($return['error'] == 1) {
                return json($return);
            }
            $userid = $returntoken['data']['userid'];
            $project_list = Offer::withSearch(['supplyid'], ['supplyid' => $userid])
            ->append(['iname','icompany','ipname','istarttime','iendtime'])
               ->page($page, $number)->order('id desc')->select();
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
     //查看报价
     public function offercheck()
     {
         try {
             $id = input('id');
             $project_list = Offer::get($id);
             $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];
         } catch (Exception $e) {
             $arr = ['msg' => '必填项不能为空', $e->getMessage(), 'error' => 1];
         }
         return json($arr);
     }
     
    //http://lzjh.com/Index/Inquiry/offeradd?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2Mzc2Njk2MzksIm5iZiI6MTYzNzA2NDgzOSwiaWF0IjoxNjM3MDY0ODM5LCJ1c2VyaWQiOjEsInR5cGUiOiIxIiwidXNlcm5hbWUiOiJhZG1pbiJ9.k8SJUyovJs-qY6X1OX-_8yLmWY4HmvAUQMIqA1jpYHs&iid=1&tax=17&material=/public/aaa.txt&mprice=100000&name=王先生&tel=13888888888&remark=备注&enclosure=/public/bbb.txt
}