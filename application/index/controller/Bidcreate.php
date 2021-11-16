<?php

namespace app\index\controller;

use app\model\Bidcreate as ModelBidcreate;
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
                ->withAttr('category', function ($value) {
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
   // http://lzjh.com/index/Bidcreate/bidcreateadd?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2Mzc1NjI0NDgsIm5iZiI6MTYzNjk1NzY0OCwiaWF0IjoxNjM2OTU3NjQ4LCJ1c2VyaWQiOjMsInR5cGUiOiIyIiwidXNlcm5hbWUiOiIxMzg0MDQ2MzI4NSJ9.2Q2sULiN-Jftka31IXuGmSoOTq0LyZ1G8C6BzuQ4k_E&btype=1&pid=1&bname=1&bmode=1&sid=1&iid=1&rname=1&phone=1&mtype=1&mlist=1&requirement=1&endtime=1&calibrationtime=1&approachtime=1&songbiao=1&songhuo=1&address=1&otype=1&floatprice=1&payment=1&invoice=1&bondtype=1&bondprice=1&enclosure=1&userid=3&examine=1
}
