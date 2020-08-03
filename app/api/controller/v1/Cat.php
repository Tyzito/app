<?php


namespace app\api\controller\v1;


use app\api\controller\Common;

class Cat extends Common
{
    public function read()
    {
        $cats = config('category.lists');

        $result[] = [
            'catid' => 0,
            'catname' => '首页'
        ];

        foreach($cats as $cid => $cname){
            $result[] = [
                'catid' => $cid,
                'catname' => $cname
            ];
        }

        return show(1,'ok',$result,200);
    }
}