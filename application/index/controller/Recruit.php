<?php

namespace app\index\controller;

use app\model\Recruit as RecruitModel;
use app\model\User;
use Exception;
use think\Controller;

class Recruit extends Controller
{
    //采购商项目列表
    public function _empty()
    {
        $arr = ['msg' => '错误的方法', 'error' => 1];
        return json($arr);
    }
    public function recruitlist()
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
            $project_list = RecruitModel::withSearch(['userid'], ['userid' => $userid])
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
    public function recruitadd()
    {
        // register_shutdown_function( 'close' );
        try {
            $project = new RecruitModel();
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
                $category = input('category');
                $data['category'] = json_decode($category, true);
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
    public function recruitcheck()
    {
        try {
          $id=input('id');
          $project_list = RecruitModel::get($id);
          $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];
        } catch (Exception $e) {
            $arr = ['msg' => '必填项不能为空', $e->getMessage(),'error' => 1];
        }
        return json($arr);
    }
    //采购项目修改
    public function recruitupdate()
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
                $project = RecruitModel::get($id);
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
    //http://lzjh.com/Index/recruit/recruitadd?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2MzYzNDAzMDUsIm5iZiI6MTYzNTczNTUwNSwiaWF0IjoxNjM1NzM1NTA1LCJ1c2VyaWQiOjMsInR5cGUiOiIxIiwidXNlcm5hbWUiOiIxMzg0MDQ2MzI4NSJ9.zO3RH5roWBRcELR0-HF5YdKHeYdZCflSt4_8Ts-On0s&type=1&name=测试招募名称&company=测试招募单位&time=2021-11-12&pid=4&itype=1&payment=微信&address=辽宁省沈阳市&qualifications=服务资质&remarks=补充说明
}
