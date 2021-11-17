<?php
namespace app\model;
use think\Model;

class Applyrecruit extends Model
{
    public function searchSupplyidAttr($query, $value)
    {
        $query->where('supplyid', '=', $value);
    }
    //招募名称
    public function getRnameAttr($value,$data)
    {
        $recruit_list = db('recruit')->select();
        foreach ($recruit_list as $v) {
            $type[$v['id']] = $v['name'];
        }
        return $type[$data['recruitid']];
    }
    //发布公司
    public function getRcompanyAttr($value,$data)
    {
        $recruit_list = db('recruit')->select();
        foreach ($recruit_list as $v) {
            $type[$v['id']] = $v['company'];
        }
        return $type[$data['recruitid']];
    }
    //项目名称
    public function getRpnameAttr($value,$data)
    {
        $recruit_list = db('recruit')->select();
        foreach ($recruit_list as $v) {
            $rid=$v['id'];
            $project=db('project')->find($rid);
            $type[$rid] = $project['pname'];
        }
        return $type[$data['recruitid']];
    }
    //开始时间
    public function getRstimeAttr($value,$data)
    {
        $recruit_list = db('recruit')->select();
        foreach ($recruit_list as $v) {
            $type[$v['id']] = $v['stime'];
        }
        return $type[$data['recruitid']];
    }
    //截止时间
    public function getRetimeAttr($value,$data)
    {
        $recruit_list = db('recruit')->select();
        foreach ($recruit_list as $v) {
            $type[$v['id']] = $v['time'];
        }
        return $type[$data['recruitid']];
    }
}