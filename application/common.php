<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

use Firebase\JWT\JWT;
// $action='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2MzYzNTY0MTQsIm5iZiI6MTYzNTc1MTYxNCwiaWF0IjoxNjM1NzUxNjE0LCJ1c2VyaWQiOjMsInR5cGUiOiIyIiwidXNlcm5hbWUiOiIxMzg0MDQ2MzI4NSJ9.oKvzRcLKwP1LeTt9X-TqphoeAKhAHrUZPK6QkiaGTvk';
function createToken($adminId,$username,$type)
{
    $secret = "THIS_IS_SECRET";      //密匙
    $payload = [               
        'exp'=>time()+3600*24*7,     //过期时间(官方字段:非必需)
        'nbf'=>time(),               //生效时间(官方字段:非必需)
        'iat'=>time(),               //签发时间(官方字段:非必需)
        'userid'=>$adminId,        //自定义字段
        'type'=>$type,
        'username'=>$username             //自定义字段
    ];
    $token = JWT::encode($payload,$secret,'HS256');
    return $token;
}
function checkToken($jwt)
{
    $key = 'THIS_IS_SECRET';
    try {
        JWT::$leeway = 60;//当前时间减去60，把时间留点余地
        $decoded = JWT::decode($jwt, $key, ['HS256']); //HS256方式，这里要和签发的时候对应
        $arr = (array)$decoded;

        $returndata['code'] = "200";//200=成功
        $returndata['msg'] = "成功";//
        $returndata['data'] = $arr;//返回的数据
        return $returndata; //返回信息

    } catch (\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
        //echo "2,";
        //echo $e->getMessage();
        $returndata['code'] = "101";//101=签名不正确
        $returndata['msg'] = $e->getMessage();
        $returndata['data'] = "";//返回的数据
        return $returndata; //返回信息
    } catch (\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
        //echo "3,";
        //echo $e->getMessage();
        $returndata['code'] = "102";//102=签名不正确
        $returndata['msg'] = $e->getMessage();
        $returndata['data'] = "";//返回的数据
        return $returndata; //返回信息
    } catch (\Firebase\JWT\ExpiredException $e) {  // token过期
        //echo "4,";
        //echo $e->getMessage();
        $returndata['code'] = "103";//103=签名不正确
        $returndata['msg'] = $e->getMessage();
        $returndata['data'] = "";//返回的数据
        return $returndata; //返回信息
    } catch (Exception $e) {  //其他错误
        //echo "5,";
        //echo $e->getMessage();
        $returndata['code'] = "199";//199=签名不正确
        $returndata['msg'] = $e->getMessage();
        $returndata['data'] = "";//返回的数据
        return $returndata; //返回信息
    }
    //Firebase定义了多个 throw new，我们可以捕获多个catch来定义问题，catch加入自己的业务，比如token过期可以用当前Token刷新一个新Token
}
//调用这个函数，将其幻化为数组，然后取出对应值
function object_array($array)
{
   if(is_object($array))
   {
    $array = (array)$array;
   }
   if(is_array($array))
   {
    foreach($array as $key=>$value)
    {
     $array[$key] = object_array($value);
    }
   }
   return $array;
}
//判断是否为供应商账号
function judgelogin($type)
{
    try {
        if ($type != 2) {
            throw new Exception('此账号不是采购商账号');
        }
        $arr = ['msg' => '成功', 'error' => 0];
    }catch(Exception $e)
    {
        $arr = ['msg' => $e->getMessage(), 'error' => 1];
    }
    return $arr;
}
//判断是否是采购商
function gongyinglogin($type)
{
    try {
        if ($type != 1) {
            throw new Exception('此账号不是供应商账号');
        }
        $arr = ['msg' => '成功', 'error' => 0];
    }catch(Exception $e)
    {
        $arr = ['msg' => $e->getMessage(), 'error' => 1];
    }
    return $arr;
}
