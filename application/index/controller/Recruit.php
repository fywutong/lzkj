<?php

namespace app\index\controller;

use app\model\Recruit as RecruitModel;
use app\model\Applyrecruit;
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
            $id = input('id');
            $project_list = RecruitModel::get($id);
            $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];
        } catch (Exception $e) {
            $arr = ['msg' => '必填项不能为空', $e->getMessage(), 'error' => 1];
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
    //供应商全部应募
    public function recruitsupplylist()
    {
        $page = input('page');
        $number = input('number');
        $data = input();
        $project_list = RecruitModel::where('examine = 2')
            //->whereTime('time',date('Y-m-d'))
            ->whereTime('time', date('Y-m-d')) // 大于某个时间
            ->where(function ($query) use ($data) {
                $search = isset($data['name']) ? $data['name'] : '';
                if ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
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
                    $query->where('time > ' . date('Y-m-d') . ' or time is null');
                    $query->where('examine', '=', 1);
                } else if ($search == 5) {
                    $query->where('time < ' . date('Y-m-d') . ' and examine = 1');
                }
            })
            ->withAttr('category', function ($value) {
                return json_decode($value, true);
            })->page($page, $number)->select();
        $count = count($project_list);
        $project_list['count'] = $count;
        $project_list['page'] = $page;
        $project_list['number'] = $number;
        $arr = ['msg' => '成功', 'data' => $project_list, 'error' => 0];

        return json($arr);
    }
    //供应商申请应募
    public function applyrecruit()
    {
        $Applyrecruit = new Applyrecruit();
        try {
            $token = input('token');
            $returntoken = checkToken($token);
            $data = input();
            if (empty($token)) {
                $arr = ['msg' => 'token不能为空', 'error' => 1];
            }else if ($returntoken['code'] == 200) {
                //判断是否为供应商
                $return = gongyinglogin($returntoken['data']['type']);
                if ($return['error'] == 1) {
                    return json($return);
                }
                $userid = $returntoken['data']['userid'];
                $data['supplyid'] = $userid;
                $add =  $Applyrecruit->save($data);
                if ($add) {
                    $arr = ['msg' => '应募成功', 'error' => 0];
                } else {
                    $arr = ['msg' => '应募失败，异常错误', 'error' => 1];
                }
            }
        } catch (Exception $e) {
            $arr = ['msg' => '必填项不能为空', 'catch' => $e->getMessage(), 'error' => 1];
        }
        return json($arr);
    }
    //http://lzjh.com/Index/recruit/applyrecruit?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2Mzc2Njk2MzksIm5iZiI6MTYzNzA2NDgzOSwiaWF0IjoxNjM3MDY0ODM5LCJ1c2VyaWQiOjEsInR5cGUiOiIxIiwidXNlcm5hbWUiOiJhZG1pbiJ9.k8SJUyovJs-qY6X1OX-_8yLmWY4HmvAUQMIqA1jpYHs&recruitid=4&cname=测试供应商公司名称&name=联系人&tel=13888888888&address=辽宁省沈阳市&type=测试品类
}
