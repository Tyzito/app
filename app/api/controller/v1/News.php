<?php


namespace app\api\controller\v1;


use app\api\controller\Common;
use think\Exception;

class News extends Common
{
    public function index()
    {
        $data = input('get.');
        if(!empty($data['title'])){
            $whereData[] = ['title','like','%'. $data['title'] .'%'];
        }

        $whereData[] = ['catid','=',input('get.catid',0,'intval')];

        $total = \app\admin\model\News::getNewsCountCondition($whereData);

        $this->getPageAndSize($data);
        $news = \app\admin\model\News::getNewsCondition($whereData,$this->from,$this->size);

        $result = [
            'total' => $total,
            'page_num' => ceil($total / $this->size),
            'lists' => $news
        ];

        return show(1,'ok',$result,200);
    }

    public function read()
    {
        $id = input('id');
        if(empty($id)){
            throw new Exception('id 不能为空',404);
        }

        $new = \app\admin\model\News::find($id);

        $cat = config('category.lists');
        $new['catname'] = $cat[$new->catid];
        if(empty($new) || $new->getData('status') != 1){
            throw new Exception('新闻不存在',404);
        }

        \app\admin\model\News::where('id',$id)->inc('read_count')->update();

        return show(1,'ok',$new,200);
    }
}