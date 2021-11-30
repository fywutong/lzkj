<?php
namespace app\model;
use think\Model;

class Supplybid extends Model
{
    public function searchSidAttr($query, $value)
    {
        $query->where('sid', '=', $value);
    }
    // public function searchEndtimeAttr($query, $value)
    // {
    //     $query->where('sid', '=', $value);
    // }
    public function getBnameAttr($value,$data)
    {
        $bidcreate_list = db('bidcreate')->select();
        foreach ($bidcreate_list as $v) {
            $type[$v['id']] = $v['bname'];
        }
        return $type[$data['bid']];
    }
    public function getBcnameAttr($value,$data)
    {
        $bidcreate_list = db('bidcreate')->select();
        foreach ($bidcreate_list as $v) {
            $find=db('user')->find($v['userid']);
            $type[$v['id']] = $find['cname'];
        }
        return $type[$data['bid']];
    }
    public function getBmodeAttr($value,$data)
    {
        $bidcreate_list = db('bidcreate')->select();
        foreach ($bidcreate_list as $v) {
            $type[$v['id']] = $v['bmode'];
        }
        return $type[$data['bid']];
    }
    public function getEndtimeAttr($value,$data)
    {
        $bidcreate_list = db('bidcreate')->select();
        foreach ($bidcreate_list as $v) {
            $type[$v['id']] = $v['endtime'];
        }
        return $type[$data['bid']];
    }
    public function getCalibrationtimeAttr($value,$data)
    {
        $bidcreate_list = db('bidcreate')->select();
        foreach ($bidcreate_list as $v) {
            $type[$v['id']] = $v['calibrationtime'];
        }
        return $type[$data['bid']];
    }
}