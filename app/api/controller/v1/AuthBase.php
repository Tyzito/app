<?php


namespace app\api\controller\v1;


use app\admin\model\EntUser;
use app\api\controller\Common;
use app\common\lib\Aes;

class AuthBase extends Common
{
    public $user;

    public function __construct()
    {
        parent::__construct();

        if(empty($this->isLogin())){
            return show(0,'您还没有登录',[],403);
        }
    }

    /**
     * 判断用户是否登录
     */
    public function isLogin()
    {
        if(empty($this->headers['access-user-token'])){
            return false;
        }

        $obj = new Aes();
        $accessUserToken = $obj->decrypt($this->headers['access-user-token']);

        if(empty($accessUserToken)){
            return false;
        }

        list($token,$id) = explode('||',$accessUserToken);

        $user = EntUser::where('token',$token)->find();

        $this->user = $user;

        return true;
    }
}