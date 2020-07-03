<?php
namespace app\admin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;
use liliuwei\think\Jump;

class Index extends Base
{
    use Jump;

    public function index()
    {
        return View::fetch();
    }

    public function welcome()
    {
        return View::fetch();
    }
}
