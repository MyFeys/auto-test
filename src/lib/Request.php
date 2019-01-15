<?php
namespace AutoTest\Lib;

use AutoTest\Filter\Filter;
use AutoTest\Filter\HandlerDelete;
use AutoTest\Filter\HandlerGet;
use AutoTest\Filter\HandlerHead;
use AutoTest\Filter\HandlerNoPassMethods;
use AutoTest\Filter\HandlerNoPassTags;
use AutoTest\Filter\HandlerOptions;
use AutoTest\Filter\HandlerPassMethods;
use AutoTest\Filter\HandlerPassTags;
use AutoTest\Filter\HandlerPatch;
use AutoTest\Filter\HandlerPost;
use AutoTest\Filter\HandlerPut;
use GuzzleHttp\RequestOptions;

/**
 * 【责任链模式】构建一个请求对象
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
class Request
{
    public $swaggerJson = '';   // swagger.json地址
    public $header = [];        // header认证信息
    /**
     * 过滤器
     * @var Filter $filter
     */
    public $filter;

    public function start()
    {
        $swagger = (new SwaggerAnalyze($this->swaggerJson));
        $this->filter->swagger = $swagger;

        $resultData = [];
        foreach ($swagger->paths as $k => $path) {
            try {
                // 1、过滤
                $this->filter->currentPathKey = $path->path;
                $this->filter->currentPathTags = $swagger->getCurrentPathTags($path);

                if (!empty($this->filter->passTags)) {
                    $result = (new HandlerPassTags())->filter($this->filter);
                    if (!$result) {
                        continue;
                    }
                } elseif (!empty($this->filter->noPassTags)) {
                    $result = (new HandlerNoPassTags())->filter($this->filter);
                    if (!$result) {
                        continue;
                    }
                } elseif (!empty($this->filter->passMethods)) {
                    $result = (new HandlerPassMethods())->filter($this->filter);
                    if (!$result) {
                        continue;
                    }
                } elseif (!empty($this->filter->noPassMethods)) {
                    $result = (new HandlerNoPassMethods())->filter($this->filter);
                    if (!$result) {
                        continue;
                    }
                }

                $consumes = isset($swagger->consumes[0]) ? $swagger->consumes[0] : 'application/json';
                $headers = array_merge(
                    [
                        'accept' => $consumes,
                        'Content-Type' => $consumes,
                    ],
                    $this->header
                );
                $this->filter->http = new Http(
                    [
                        'verify' => 0,
                        'headers' => $headers
                    ]);
                $this->filter->http->sendPrefix = ($consumes == 'application/json') ? RequestOptions::JSON : RequestOptions::FORM_PARAMS;

                $this->filter->currentPath      = $path;

                // 2、发起请求
                $get        = new HandlerGet();
                $put        = new HandlerPut();
                $post       = new HandlerPost();
                $delete     = new HandlerDelete();
                $options    = new HandlerOptions();
                $head       = new HandlerHead();
                $patch      = new HandlerPatch();

                $get->setNext($put)
                    ->setNext($post)
                    ->setNext($delete)
                    ->setNext($options)
                    ->setNext($head)
                    ->setNext($patch);

                $get->filter($this->filter);

                // 3、返回结果
                $request = "request：【".$this->filter->http->name."】".$this->filter->http->url."【params】" . json_encode($this->filter->http->params);
                $response = "response：".json_encode($this->filter->http->data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                $resultData[] = [
                    'request' => $request,
                    'response' => $response
                ];
            } catch (\Exception $e) {
                echo json_encode('error~'.$path->path.$e->getMessage(), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)."\n";
                continue;
            }
        }

        return $resultData;
    }
}
