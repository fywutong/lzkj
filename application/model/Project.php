<?php
namespace app\model;
use think\Model;
use app\model\User;
class Project extends Model
{
    public function searchUseridAttr($query, $value)
    {
        $query->where('userid', '=', $value);
    }
    // public function searchPnameAttr($query, $value)
    // {
    //     $query->where('pname', 'like', '%'.$value.'%');
    // }

}