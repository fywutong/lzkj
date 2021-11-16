<?php
namespace app\model;
use think\Model;
use app\model\Type;
class News extends Model
{
    //获取器
    public function getTypeAttr($value)
    {
        $type_list=Type::select();
        foreach($type_list as $v)
        {
            $type[$v['id']] = $v['name'];
        }
        //$type = [-1=>'删除', 0=>'禁用', 1=>'正常', 2=>'待审核'];
        return $type[$value];
    }
}