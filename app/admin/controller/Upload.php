<?php


namespace app\admin\controller;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use think\Exception;

class Upload
{
    public static function image()
    {
        // 上传的文件
        if(empty($_FILES['file']['tmp_name'])){
            throw new Exception('你上传的图片不存在');
        }

        // 要上传的文件
        $file = $_FILES['file']['tmp_name'];
        // 获取扩展名
        $extension = pathinfo($_FILES['file']['name'])['extension'];
        // 上传到七牛云后保存的文件名
        $filename = date('Y').'/'.date('m').'/'.substr(md5($file),0,5).date('YmdHis').rand(0,9999).'.'.$extension;

        $accessKey = config('upload.accessKey');
        $secretKey = config('upload.secretKey');
        $bucket = config('upload.bucket');

        // 初始化鉴权
        $auth = new Auth($accessKey, $secretKey);
        // 生成上传token
        $uploadToken = $auth->uploadToken($bucket);
        // 构建 uploadManager 对象
        $uploadMgr = new UploadManager();
        list($res, $err) = $uploadMgr->putFile($uploadToken,$filename,$file);

        if($err !== null){
            return null;
        }

        return $filename;
    }
}