<?php
namespace app\model;
use think\Model;

class Supplybid extends Model
{
    public function searchSidAttr($query, $value)
    {
        $query->where('sid', '=', $value);
    }

}