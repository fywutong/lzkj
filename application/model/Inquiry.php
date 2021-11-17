<?php
namespace app\model;
use think\Model;
use app\model\Type;
class Inquiry extends Model
{
    public function searchUseridAttr($query, $value)
    {
        $query->where('userid', '=', $value);
    }
}