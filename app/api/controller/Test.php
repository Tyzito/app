<?php


namespace app\api\controller;


use app\BaseController;
use app\common\exception\ApiHandleException;
use app\common\lib\Aes;
use think\Db;
use think\Exception;
use think\exception\HttpException;

class Test extends Common
{
    public function index()
    {
        /*if($data['id']){
            dd(111);
        }*/
        return show(1,'success',[
            'username' => 'zhangsan',
            'age' => 23,
            'sex' => 'w',
        ]);
    }

    public function save()
    {
        return show(1,'success',(new Aes())->encrypt(json_encode(input('post.'))),202);
    }

    public function update($id)
    {
        return show(1,'success',[
            'username' => input('username'),
            'age' => $id,
            'sex' => 'm',
        ]);
    }

    public function delete($id)
    {
        echo $id.'hgehge';exit;
    }
}