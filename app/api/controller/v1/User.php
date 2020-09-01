<?php


namespace app\api\controller\v1;


use app\admin\model\EntUser;
use app\common\lib\Aes;

class User extends AuthBase
{
    /**
     * 获取用户信息
     * @return \think\response\Json
     */
    public function read()
    {
        $obj = new Aes();
        return show(1,'success',$obj->encrypt($this->user));
    }

    /**
     * 更新个人信息
     */
    public function update()
    {
        $param = input('param.');

        $data = [];
        if(!empty($param['image'])){
            $data['image'] = $param['image'];
        }

        if(!empty($param['username'])){
            $data['username'] = $param['username'];
        }

        if(!empty($param['sex'])){
            $data['sex'] = $param['sex'];
        }

        if(!empty($param['password'])){
            $data['password'] = md5($param['password']);
        }

        if(!empty($param['signature'])){
            $data['signature'] = $param['signature'];
        }

        try {
            $user = EntUser::find($this->user['id']);
            $id = $user->save($data);

            if($id){
                return show(1,'success');
            }

            return show(0,'error',403);
        }catch (\Exception $e){
            return show(0,$e->getMessage(),403);
        }
    }
}