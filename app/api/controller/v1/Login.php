<?php


namespace app\api\controller\v1;


use app\admin\model\EntUser;
use app\api\controller\Common;
use app\common\lib\Aes;
use app\common\lib\Alidayu;

class Login extends Common
{
    public function save()
    {
        if(!request()->isPost()){
            return show(0,'请求不合法',[],403);
        }

        $param = input('param.');
        if(empty($param['phone'])){
            return show(0,'手机号不能为空',[],403);
        }

        if(empty($param['code']) && empty($param['password'])){
            return show(0,'验证码和密码不能为空',[],403);
        }

        if(!empty($param['code'])){
            $code = Alidayu::getInstance()->checkSmsIdentify($param['phone']);
            if($param['code'] != $code){
                return show(0,'您输入的验证码不正确',[],403);
            }
        }

        $token = setAppLoginToken($param['phone']);

        // 查询手机号是否存在
        $user = EntUser::where(['phone' => $param['phone']])->find();
        $result = [
            'token' => $token,
            'time_out' => strtotime("+7 days")
        ];
        if($user && $user->status == 1){
            if(!empty($param['password'])){
                if(md5($param['password']) != $user->password){
                    return show(0,'密码不正确',[],403);
                }
            }
            $id = $user->save($result);
        }else{
            if(!empty($param['code'])){
                // 第一次登录
                $data = [
                    'token' => $token,
                    'phone' => $param['phone'],
                    'username' => 'APP粉-'.$param['phone'],
                    'time_out' => strtotime("+7 days"),
                ];

                $id = (new EntUser())->add($data);
            }else{
                return show(0,'用户不存在',[],403);
            }
        }

        if($id){
            $result = [
                'token' => (new Aes())->encrypt($token.'||'.$param['phone'])
            ];

            return show(1,'success',$result,200);
        }

        return show(0,'error',[],403);
    }
}