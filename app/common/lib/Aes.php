<?php
namespace app\common\lib;

/**
 * aes 加密 解密类库
 * @by singwa
 * Class Aes
 * @package app\common\lib
 */
class Aes {

    public $str;
    protected $method = 'DES-ECB';
    public $sign = '123456';

    public function encrypt($str)
    {
        return openssl_encrypt($str,$this->method,$this->sign);
    }

    public function decrypt($str)
    {
        return openssl_decrypt($str, $this->method,$this->sign);
    }

}