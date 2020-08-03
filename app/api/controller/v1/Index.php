<?php


namespace app\api\controller\v1;


use app\admin\model\News;
use app\api\controller\Common;

class Index extends Common
{
    /**
     * 获取首页头图接口
     * @return \think\response\Json
     */
    public function index()
    {
        $head = News::getIndexHeadNormalNews();
        $headRes = $this->getHeadNews($head);

        $position = News::getPositionNormalNews();
        $positionRes = $this->getHeadNews($position);

        $result = [
            'heads' => $headRes,
            'position' => $positionRes
        ];

        return show(1,'ok',$result,200);
    }
}