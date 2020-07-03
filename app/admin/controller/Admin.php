<?php
namespace app\admin\controller;

use app\admin\model\AdminUser as adminUserModel;
use app\BaseController;
use app\common\validate\AdminUser;
use liliuwei\think\Jump;
use think\facade\Db;
use think\facade\View;

class Admin extends Base
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
            $data['password'] = md5($data['password'].config('common.salt'));

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
