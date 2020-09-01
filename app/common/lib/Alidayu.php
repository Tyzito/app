<?php


namespace app\common\lib;


use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use think\facade\Cache;
use think\facade\Log;

class Alidayu
{

    /**
     * 私有静态成员变量(保存全局实例)
     * @var null
     */
    private static $_instance = null;

    /**
     * 单例模式
     * 私有构造方法
     */
    private function __construct()
    {

    }

    /**
     * 访问实例的静态方法
     * 单例模式的统一入口
     */
    public static function getInstance()
    {
        if(is_null(self::$_instance)){
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * 设置短信验证
     * @param int $phone
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function setSmsIdentify($phone = 0)
    {
        $code = mt_rand(1000,9999);

        AlibabaCloud::accessKeyClient(config('app.alidayu.access_key'), config('app.alidayu.secret_key'))
            ->regionId('cn-hangzhou')
            ->asDefaultClient();

        try{
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumbers' => $phone,
                        'SignName' => config('app.alidayu.sign_name'),
                        'TemplateCode' => config('app.alidayu.template_code'),
                        'TemplateParam' => "{\"code\":$code}",
                    ],
                ])
                ->request()->toArray();
        }catch (ClientException $e) {
            Log::write("set-----".$e->getErrorMessage());
            $e->getErrorMessage();
        } catch (ServerException $e) {
            $e->getErrorMessage();
        }

        if($result['Code'] === 'OK'){
            Cache::set($phone, $code, 120);
            return true;
        }

        return false;
    }

    /**
     * 查询验证码缓存是否有效
     */
    public function checkSmsIdentify($phone = 0)
    {
        if(!$phone){
            return false;
        }

        return Cache::get($phone);
    }
}