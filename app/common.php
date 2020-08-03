<?php
// 应用公共文件

/**
 * 通用化API接口数据输出
 * @param $status 业务状态码
 * @param $msg 信息提示
 * @param array $data 数据
 * @param $httpCode http状态码
 * @return \think\response\Json
 */
function show($status,$msg,$data = [],$httpCode = 200)
{
    $res = [
        'status' => $status,
        'message' => $msg,
        'data' => $data
    ];

    return json($res,$httpCode);
}

/**
 * 生成每次请求的 sign
 * @param array $data
 */
function setSign($data = [])
{
    ksort($data);
    $string = http_build_query($data);

    return (new \app\common\lib\Aes())->encrypt($string);
}

function checkSignPass($data)
{
    $str = (new \app\common\lib\Aes())->decrypt($data['sign']);

    if(empty($str)){
        return false;
    }

    parse_str($str, $arr);

    if(!is_array($arr) || empty($arr['did']) || $arr['did'] != $data['did']){
        return false;
    }

    if(!env('app_debug')){
        if(\think\facade\Cache::get($data['sign'])){
            return false;
        }
    }

    return true;
}