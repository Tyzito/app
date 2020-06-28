<?php
namespace app\admin\model;

use think\Exception;
use think\Model;

class AdminUser extends Model
{
    public function add($data)
    {
        if(!is_array($data)){
            throw new Exception('参数不合法');
        }

        $this->save($data);

        return $this->id;
    }
}