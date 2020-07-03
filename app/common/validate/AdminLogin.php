<?php
namespace app\common\validate;


use think\Validate;

class AdminLogin extends Validate
{
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
        'code' => 'require',
    ];
}