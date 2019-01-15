<?php
namespace AutoTest\Lib;

/**
 * 【责任链模式】构建一个请求对象
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
abstract class RequestHandler
{
    // 下一个handler对象
    private $nextHandler;

    /**
     * 处理
     *
     * @param Request $request 请求对象
     */
    abstract public function handler(Request $request);

    /**
     * 设置责任链上的下一个对象
     * @param RequestHandler $handler
     * @return RequestHandler
     */
    public function setNext(RequestHandler $handler)
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    /**
     * 启动
     * @param Request $request
     */
    public function start(Request $request)
    {
        $this->handler($request);
        // 调用下一个对象
        if (!empty($this->nextHandler)) {
            $this->nextHandler->start($request);
        }
    }
}