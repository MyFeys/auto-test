<?php
namespace AutoTest;

use AutoTest\Filter\Filter;
use AutoTest\Lib\Request;
use AutoTest\Report\EmailReport;
use AutoTest\Report\Report;
use AutoTest\Report\ScreenReport;

/**
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
class Router
{
    public function __construct()
    {
//        echo "start test...\n";
    }

    public function single()
    {
        set_time_limit(0);
        // 需要过滤
        $filter = new Filter();
        $filter->passTags = [];
        $filter->passMethods = [];

        $request = new Request();
        $request->filter = $filter;
        $request->swaggerJson = dirname(dirname(__FILE__)) . '/config/swagger.json';
//        $request->header = (new Header())->getHeader();

        $result = $request->start();

        // 直接打印
        $screenStrategy = (new Report(new ScreenReport()));
        $screenStrategy->data = $result;
        $screenStrategy->generate();
        // 邮件发送报告
//        $emailStrategy = new Report(new EmailReport());
//        $emailStrategy->data = $result;
//        $emailStrategy->generate();
    }

    public function __destruct()
    {
//        echo "end test...\n";
    }
}