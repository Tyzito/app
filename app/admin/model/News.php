<?php
namespace app\admin\model;

class News extends Base
{
    protected $table = 'news';

    /*public function getCatIdAttr($value)
    {
        $category = config('category.lists');
        return $category[$value];
    }*/

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

        /*if(!empty($data['catid'])){
            $where['catid'] = $data['catid'];
        }

        if(!empty($data['title'])){
            $where['title'] = ['like','%'.$data['title'].'%'];
        }

        $where['status'] = 1;

        $order = [
            'id' => 'desc'
        ];*/

        $res = self::where('status',1)
            ->where(function ($query) use ($data){
                if(!empty($data['title'])){
                    $query->whereLike('title','%'.$data['title'].'%');
                }
            })
            ->where(function ($query) use ($data){
                if(!empty($data['catid'])){
                    $query->where('catid',$data['catid']);
                }
            })
            ->where(function ($query) use ($data){
                if(!empty($data['start_time']) && !empty($data['end_time']) && $data['start_time'] < $data['end_time']){
                    $query->whereTime('create_time','>',strtotime($data['start_time']))->whereTime('create_time','<',strtotime($data['end_time']));
                }
            })
            ->order('id','desc')
            ->paginate(config('view.paginate'));

        return $res;
    }

    public static function getNewsCondition($whereData,$form,$size)
    {
        $whereData[] = ['status','=',1];
        $order = [
            'id' => 'desc'
        ];

        $res = self::where($whereData)
            ->order($order)
            ->limit($form,$size)
            ->select();

        return $res;
    }

    public static function getNewsCountCondition($whereData)
    {
        $whereData[] = ['status','=',1];
        $order = [
            'id' => 'desc'
        ];

        return self::where($whereData)->order($order)->count();
    }

    public static function getIndexHeadNormalNews($num = 4)
    {
        $data = [
            'status' => 1,
            'is_head_figure' => 1
        ];

        $order = [
            'id' => 'desc'
        ];

        return self::field(self::getListField())
            ->where($data)
            ->order($order)
            ->limit($num)
            ->select();
    }

    public static function getRankNormalNews($num = 4)
    {
        $data = [
            'status' => 1,
        ];

        $order = [
            'read_count' => 'desc'
        ];

        return self::field(self::getListField())
            ->where($data)
            ->order($order)
            ->limit($num)
            ->select();
    }

    public static function getPositionNormalNews($num = 20)
    {
        $data = [
            'status' => 1,
            'is_position' => 1
        ];

        $order = [
            'id' => 'desc'
        ];

        return self::field(self::getListField())
            ->where($data)
            ->order($order)
            ->limit($num)
            ->select();
    }

    private static function getListField()
    {
        return [
            'id',
            'catid',
            'image',
            'title',
            'read_count'
        ];
    }
}