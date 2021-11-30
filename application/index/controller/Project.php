<?php
namespace app\index\controller;

use app\model\Project as ProjectModel;
use app\model\User;
use Exception;
use think\Controller;
header("Access-Control-Allow-Origin: *");
class Project extends Controller
{
    
    public function _empty()
    {
        $arr = ['msg' => '错误的方法', 'error' => 1];
        return json($arr);
    }
    //采购商项目列表
    public function projectlist()
    {
        $token = input('token');
        $page = input('page');
        $number = input('number');
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
            $project_list = ProjectModel::withSearch(['userid'], ['userid' => $userid])
                ->where(function ($query) use ($data) {
                    $search = isset($data['examine']) ? $data['examine'] : '';
                    if ($search) {
                        $query->where('examine', '=', $search);
                    }
                })
                ->where(function ($query) use ($data) {
                    $search = isset($data['pname']) ? $data['pname'] : '';
                    if ($search) {
                        $query->where('pname', 'like', '%' . $search . '%');
                    }
                })
                ->withAttr('username', function ($value, $data) {
                    $user_list = User::select();
                    foreach ($user_list as $v) {
                        $type[$v['id']] = $v['name'];
                    }
                    return $type[$data['userid']];
                })->append(['username'])->page($page, $number)->order('id desc')->select();
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
    public function projectadd()
    {
        $project = new ProjectModel();
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
            $data['ddh']=time().rand('1111,9999');
            $data['time'] = date('Y-m-d');
            $save = $project->save($data);
            if ($save) {
                $arr = ['msg' => '添加成功', 'error' => 0];
            } else {
                $arr = ['msg' => '添加失败，异常错误', 'error' => 1];
            }
        } else {
            $arr = ['msg' => $returntoken['msg'], 'error' => 1];
        }
        return json($arr);
    }
    public function projectcheck()
    {
        try {
          $id=input('id');
          $project_list = ProjectModel::get($id);
          $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];
        } catch (Exception $e) {
            $arr = ['msg' => '必填项不能为空', $e->getMessage(),'error' => 1];
        }
        return json($arr);
    }
    //采购项目修改
    public function projectupdate()
    {
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
            $id = $data['id'];
            $project = ProjectModel::get($id);
            $save = $project->save($data);
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
    //http://lzjh.com/Index/project/projectadd?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2MzU3MzM3MjAsIm5iZiI6MTYzNTEyODkyMCwiaWF0IjoxNjM1MTI4OTIwLCJ1c2VyaWQiOjMsInR5cGUiOiIxIiwidXNlcm5hbWUiOiIxMzg4ODg4ODg4OCJ9.n1qEdiqk4odO-vhUnUJv5wfcLkD9_ARi30t7xID2aBk&pname=测试项目名称&description=项目描述&address=辽宁省沈阳市&name=王先生&tel=13888888888&company=网盛生意宝&ptype=测试项目类型&areacovered=50&barea=80&cycle=5&images=/public/index/aaa.jpg&choice=1&state=1&price=200
}
