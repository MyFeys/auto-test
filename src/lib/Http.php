<?php
namespace AutoTest\Lib;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

/**
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
class Http
{
    private $client;
    public $sendPrefix = 'form_params';
    public $method;
    public $url;
    public $params;

    public $name;
    public $code;
    public $data;

    public function __construct($config = [])
    {
        $this->client = new Client($config);
    }

    public function put()
    {
        $this->method = 'PUT';
        $this->params = [$this->sendPrefix => $this->params];
        return $this->send();
    }

    public function post()
    {
        $this->method = 'POST';
        $this->params = [$this->sendPrefix => $this->params];
        return $this->send();
    }

    /**
     * ['query' => ['foo' => 'bar']]
     */
    public function get()
    {
        $this->method = 'GET';
        $this->params = ['query' => $this->params];
        return $this->send();
    }

    public function delete()
    {
        $this->method = 'DELETE';
        $this->params = ['query' => $this->params];
        return $this->send();
    }

    private function send()
    {
        $response = $this->client->request($this->method, $this->url, $this->params);

        $this->code = $response->getStatusCode();
        $this->data = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        return $this;
    }
}
