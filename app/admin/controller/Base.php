<?php

namespace app\admin\controller;


use app\BaseController;
use liliuwei\think\Jump;


class Base extends BaseController
{

    use Jump;

    public function __construct()
    {
        parent::__construct();
        $isLogin = $this->isLogin();
        if(!$isLogin){
            return $this->redirect('login/index');
        }
    }

    public function isLogin()
    {
        $user = session('adminUser');
        if(!$user){
            return false;
        }
        return true;
    }
}