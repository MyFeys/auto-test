<?php
namespace AutoTest\Lib;

/**
 * 【责任链模式】认证模式
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
class RequestHandlerHeader extends RequestHandler
{
    public function handler(Request $request)
    {
        echo "header ～ \n";
    }
}