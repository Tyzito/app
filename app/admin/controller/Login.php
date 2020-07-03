<?php
namespace app\admin\controller;


use app\admin\model\AdminUser;
use app\BaseController;
use app\common\validate\AdminLogin;
use think\facade\View;
use liliuwei\think\Jump;

class Login extends Base
{
    use Jump;
    /*public function __construct()
    {
    }*/

    public function index()
    {
        if(request()->isPost()){
            $data = input('post.');

            // 验证
            $validate = new AdminLogin();
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }

            // 验证用户名
            $adminUser = AdminUser::where('username',$data['username'])->find();
            if(!$adminUser && $adminUser->status != 1){
                $this->error('用户名不存在');
            }

            // 验证密码
            if(md5($data['password'].config('common.salt')) != $adminUser->password){
                $this->error('密码不正确');
            }

            // 验证验证码
            if(!captcha_check($data['code'])){
                $this->error('验证码不正确');
            }

            // 更新数据库
            AdminUser::update([
                'last_login_ip' => request()->ip(),
                'last_login_time' => time(),
            ],['id' => $adminUser->id]);

            // 存session
            session('adminUser',$adminUser);

            $this->success('登录成功','index/index');
        }else{

            if($this->isLogin()){
                return $this->redirect('index/index');
            }else{
                return View::fetch();
            }

            //return View::fetch();
        }
    }

    public function logout()
    {
        session('adminUser',null);

        return $this->redirect('index');
    }
}