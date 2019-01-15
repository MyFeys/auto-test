<?php
namespace AutoTest\Lib;

/**
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
class Header
{
    private $url = 'http://arrayhua.github.io/auth/login';
    
    public function getHeader()
    {
        $header = [
            'appurl' => $this->url,
            'authorization' => $this->getToken(),
            'apptimestamp' => (string)time(),
        ];
        $header['sign'] = $this->generateSign(array_merge($header, []));
        
        return $header;
    }

    /**
     * 生成签名
     * @param  array $params 待校验签名参数
     * @return string|false
     */
    private function generateSign($params)
    {
        return '';
    }

    // 获取Authorizen认证
    private function getToken()
    {
        $loginArr = array(
            'admin_name' => '',
            'password' => '',
        );
        
        $http = new Http();
        $http->url = $this->url;
        $http->params = $loginArr;
        $http->post();

        $data = json_decode($http->data, true);

        return $data;
    }


    /**
     * md5方式签名
     * @param  array $params 待签名参数
     * @return string
     */
    private function generateMd5Sign($params)
    {
        return '';
    }
}