<?php


namespace app\api\controller\v1;


use app\api\controller\Common;
use think\Exception;

class Rank extends Common
{
    /**
     * 排行榜
     */
    public function index()
    {
        try {
            $rank = \app\admin\model\News::getRankNormalNews();
        }catch (\Exception $e){
            throw new Exception('error',500);
        }

        return show(1,'ok',$rank,200);
    }
}