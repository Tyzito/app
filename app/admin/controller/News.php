<?php


namespace app\admin\controller;


use app\BaseController;
use think\facade\View;

class News extends BaseController
{
    public function add()
    {
        return View::fetch();
    }
}