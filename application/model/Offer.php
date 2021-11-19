<?php
namespace app\model;
use think\Model;
class Offer extends Model
{
    public function searchSupplyidAttr($query, $value)
    {
        $query->where('supplyid', '=', $value);
    }
    //询价名称
    public function getInameAttr($value,$data)
    {
        $inquiry_list = db('inquiry')->select();
        foreach ($inquiry_list as $v) {
            $type[$v['id']] = $v['iname'];
        }
        return $type[$data['supplyid']];
    }
    //发布单位
    public function getIcompanyAttr($value,$data)
    {
        $inquiry_list = db('inquiry')->select();
        foreach ($inquiry_list as $v) {
            $userid=$v['userid'];
            $project=db('user')->find($userid);
            $type[$v['id']] = $project['cname'];
        }
        return $type[$data['supplyid']];
    }
    //发布单位
    public function getIpnameAttr($value,$data)
    {
        $inquiry_list = db('inquiry')->select();
        foreach ($inquiry_list as $v) {
            $type[$v['id']] = $v['pname'];
        }
        return $type[$data['supplyid']];
    }
    public function getIstarttimeAttr($value,$data)
    {
        $inquiry_list = db('inquiry')->select();
        foreach ($inquiry_list as $v) {
            $type[$v['id']] = $v['starttime'];
        }
        return $type[$data['supplyid']];
    }
    public function getIendtimeAttr($value,$data)
    {
        $inquiry_list = db('inquiry')->select();
        foreach ($inquiry_list as $v) {
            $type[$v['id']] = $v['endtime'];
        }
        return $type[$data['supplyid']];
    }
}