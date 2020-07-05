<?php
namespace app\admin\model;

class News extends Base
{
    protected $table = 'news';

    public function getCatIdAttr($value)
    {
        $category = config('category.lists');
        return $category[$value];
    }

    public function getIsPositionAttr($value)
    {
        $isPosition = [0 => '否', 1 => '是'];
        return $isPosition[$value];
    }

    public function getStatusAttr($value)
    {
        $status = [0 => '下架', 1 => '上架'];
        return $status[$value];
    }

    public static function getNews($data = [])
    {
        $where = [];

        if(!empty($data['catid'])){
            $where['catid'] = $data['catid'];
        }

        if(!empty($data['title'])){
            $where['title'] = $data['title'];
        }

        $where['status'] = 1;

        $order = [
            'id' => 'desc'
        ];

        $res = self::where($where)
            ->where(function ($query) use ($data){
                if(!empty($data['start_time']) && !empty($data['end_time']) && $data['start_time'] < $data['end_time']){
                    $query->whereTime('create_time','>',strtotime($data['start_time']))->whereTime('create_time','<',strtotime($data['end_time']));
                }
            })
            ->order($order)
            ->paginate(config('view.paginate'));

        return $res;
    }

    public static function getNewsCondition($whereData)
    {
        $condition['status'] = 1;
        $order = [
            'id' => 'desc'
        ];

        $form = ($whereData['page'] - 1) * $whereData['size'];

        $res = self::where($condition)
            ->order($order)
            ->limit($form,$whereData['size'])
            ->select();

        return $res;
    }

    public static function getNewsCountCondition($whereData)
    {
        $condition['status'] = 1;
        $order = [
            'id' => 'desc'
        ];

        return self::where($condition)->order($order)->count();
    }
}