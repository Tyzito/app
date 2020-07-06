<?php


namespace app\admin\controller;


use app\BaseController;
use think\facade\View;
use app\admin\model\News as newsModel;

class News extends BaseController
{
    public function index()
    {
        // 搜索参数
        $data = input('param.');

        // 第一种
        $lists = newsModel::getNews($data);
        $count = $lists->count();

        // 第二种
        /*$param = input('param.');
        $whereData = [];
        $whereData['page'] = !empty($param['page']) ? $param['page'] : 1;
        $whereData['size'] = !empty($param['size']) ? $param['size'] : config('view.paginate.list_rows');

        $lists = newsModel::getNewsCondition($whereData);
        $total = newsModel::getNewsCountCondition($whereData);
        $pageTotal = ceil($total/$whereData['size']);*/

        return View::fetch('',[
            'lists' => $lists,
            'count' => $count,
            'category' => config('category.lists'),
            'catid' => !empty($data['catid']) ? $data['catid'] : '',
            'title' => !empty($data['title']) ? $data['title'] : '',
            'start_time' => !empty($data['start_time']) ? $data['start_time'] : '',
            'end_time' => !empty($data['end_time']) ? $data['end_time'] : '',
            //'pageTotal' => $pageTotal,
            //'curr' => $whereData['page']
        ]);
    }

    public function add()
    {
        if(request()->isPost()){

            $data = input('post.');
            $data['status'] = 1;

            $id = (new newsModel())->add($data);

            if(!$id){
                return json(['status' => 0, 'msg' => '添加失败']);
            }

            return json(['status' => 1, 'msg' => '添加成功']);
        }else{
            return View::fetch('',[
                'categorys' => config('category.lists')
            ]);
        }
    }

    public function delete($id = 0)
    {
        if(!intval($id)){
            return json(['status' => 0,'msg' => 'ID不合法']);
        };

        try{
            $res = \app\admin\model\News::update(['status' => -1],['id' => $id]);
        }catch (\Exception $e){
            return json(['status' => 0,'msg' => $e->getMessage()]);
        }

        if(!$res){
            return json(['status' => 0,'msg' => '删除失败']);
        }

        return json(['status' => 1,'msg' => '删除成功', 'jump_url' => $_SERVER['HTTP_REFERER']]);
    }
}