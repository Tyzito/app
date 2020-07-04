<?php


namespace app\admin\controller;


use app\BaseController;
use think\facade\Filesystem;

class Image extends BaseController
{
    public function upload0()
    {
        $file = request()->file('file');
        // 上传到本地服务器
        $savename = Filesystem::disk('public')->putFile('topic',$file);

        if($savename){
            return json([
                'status' => 1,
                'message' => 'success',
                'data' => $savename,
            ]);
        }

        return json(['status' => 0, 'message' => 'error']);
    }

    public function upload()
    {
        // 上传到七牛云
        $savename = Upload::image();

        if($savename){
            return json([
                'status' => 1,
                'message' => 'success',
                'data' => config('upload.cdnDomainUrl').$savename,
            ]);
        }

        return json(['status' => 0, 'message' => 'error']);
    }
}