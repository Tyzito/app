<?php


namespace app\api\controller\v1;


use app\admin\model\Active;
use app\admin\model\Init;
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

    /**
     * 更新APP
     */
    public function init()
    {
        $app_type = Init::getAppTypeNormalEntVersion($this->headers['app-type']);

        if($app_type['version'] > intval($this->headers['version'])){
            $app_type['is_update'] = $app_type['is_force'] == 1 ? 2 : 1;
        }else{
            $app_type['is_update'] = 0;   // 0不更新 1更新 2强制更新
        }

        // 记录用户的基本信息，用户统计
        $actives = [
            'version' => $this->headers['version'],
            'app_type' => $this->headers['app-type'],
            'version_code' => $app_type->version_code,
            'did' => $this->headers['did'],
            'model' => $this->headers['model'],
        ];

        (new Active())->save($actives);

        return show(1,'ok',$app_type,200);
    }
}