<?php


namespace app\api\controller\v1;


use app\admin\controller\Upload;

class Image extends AuthBase
{
    /**
     * 上传头像
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function save()
    {
        $result = Upload::image();

        return show(1,'success',config('upload.cdnDomainUrl').$result);
    }
}