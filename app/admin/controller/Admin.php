<?php
namespace app\admin\controller;

use app\BaseController;
use app\common\validate\AdminUser;
use app\admin\model\AdminUser as adminUserModel;
use think\facade\View;
use liliuwei\think\Jump;

class Admin extends BaseController
{
    use Jump;

    public function add()
    {
        if(request()->isPost()){
            $data = input('post.');

            $validate = new AdminUser();
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }

            $data['status'] = 1;
            $data['last_login_ip'] = $_SERVER['REMOTE_ADDR'];
            $salt = 'app';
            $data['password'] = md5($data['password'].$salt);

            try{
                $id = (new adminUserModel())->add($data);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }

            if(!$id){
                $this->error('error');
            }

            $this->success('ID为'.$id.'的用户添加成功！');
        }else{
            return View::fetch();
        }
    }
}
