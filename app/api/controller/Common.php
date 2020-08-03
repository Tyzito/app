<?php


namespace app\api\controller;


use app\BaseController;
use app\common\lib\Aes;
use think\Exception;
use think\facade\Cache;

class Common extends BaseController
{
    public $headers = '';
    public $page = 1;
    public $size = 10;
    public $from = 0;

    public function __construct()
    {
        $this->checkRequestAuth();
    }

    // 检查 每次app 请求数据是否合法
    public function checkRequestAuth()
    {
        $headers = request()->header();
        $this->headers = $headers;
        if(empty($headers['sign'])){
            throw new Exception('sign不存在',400);
        }

        if(!in_array($headers['app-type'],config('app.app_types'))){
            throw new Exception('app_type不合法',400);
        }

        // 检查 sign
        if(!checkSignPass($headers)){
            throw new Exception('授权码sign失败',401);
        };

        // sign 唯一性校验
        Cache::set($headers['sign'],1,20);
    }

    public function testAes()
    {
        $str = 'id=1&id=5&username=zhangsan';
        $sign = config('app.aeskey');

        dd((new Aes())->encrypt($str));
    }

    protected function getHeadNews($news = [])
    {
        if(empty($news)){
            return [];
        }

        $cats = config('category.lists');

        foreach($news as $k => $new){
            $news[$k]['catname'] = $cats[$new['catid']] ?? '-';
        }

        return $news;
    }

    public function getPageAndSize($data)
    {
        $this->page = !empty($data['page']) ? $data['page'] : 1;
        $this->size = !empty($data['size']) ? $data['size'] : config('view.paginate.list_rows');
        $this->from = ($this->page-1) * $this->size;
    }
}