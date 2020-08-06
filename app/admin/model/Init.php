<?php


namespace app\admin\model;


class Init extends Base
{
    protected $table = 'ent_version';

    public static function getAppTypeNormalEntVersion($app_type = '')
    {
        $where[] = [
            ['status','=',1],
            ['app_type','=',$app_type],
        ];

        $res = self::where($where)
            ->order('id','desc')
            ->limit(1)
            ->find();

        return $res;
    }
}