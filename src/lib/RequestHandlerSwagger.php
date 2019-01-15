<?php
namespace AutoTest\Lib;

/**
 * 【责任链模式】swagger.json地址
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
class RequestHandlerSwagger extends RequestHandler
{
    public function handler(Request $request)
    {
        echo "swagger {$request->data}~\n";
    }
}