<?php


namespace app\api\controller\v1;


use app\api\controller\Common;
use app\common\lib\Alidayu;
use app\common\validate\Identify as valiIdentify;

class Identify extends Common
{
    public function save()
    {
        if(!request()->isPost()){
            return false;
        }

        $validate = new valiIdentify();
        if(!$validate->check(input('post.'))){
            return show(0,$validate->getError(),[],403);
        }

        $id = input('post.id');
        if(Alidayu::getInstance()->setSmsIdentify($id)){
            return show(1,'success',[],200);
        }

        return show(0,'error',[],403);
    }
}