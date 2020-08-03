<?php

namespace app\common\exception;

use think\Exception;
use think\exception\ErrorException;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\ValidateException;
use think\Response;

class ApiHandleException extends Handle
{
    public $httpCode = 403;

    public function render($request, \Throwable $e): Response
    {
        // 参数验证错误
        if($e instanceof ValidateException){
            return json(['status' => 0,'msg' => $e->getError(), 'data' => []]);
        }

        // 请求异常
        if($e instanceof HttpException && $request->isAjax()){
            return response($e->getMessage(),$e->getStatusCode());
        }

        if($e instanceof ErrorException || $request->isPost()){
            if(env('app_debug') == true){
                return parent::render($request,$e);
            }
            return json(['status' => 0,'msg' => $e->getMessage(), 'data' => []],$this->httpCode);
        }

        // 其他错误交给系统处理
        return parent::render($request,$e);
    }
}