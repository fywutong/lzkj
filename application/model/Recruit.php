<?php
namespace app\model;
use think\Model;

class Recruit extends Model
{
    public function searchUseridAttr($query, $value)
    {
        $query->where('userid', '=', $value);
    }
    

}