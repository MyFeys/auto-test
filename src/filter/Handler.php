<?php
namespace AutoTest\Filter;

/**
 * Class Handler
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-08
 * @copyright arrayhua.github.io
 */
abstract class Handler
{
  /**
   * 下一个hanler对象
   * @var [type]
   */
  private $nextHandler;

  /**
   * 校验方法
   *
   * @param Filter $filter 过滤对象
   */
  public abstract function check(Filter $filter);

  /**
   * 设置责任链上的下一个对象
   * @param Handler $handler
   * @return Handler
   */
  public function setNext(Handler $handler)
  {
    $this->nextHandler = $handler;
    return $handler;
  }

  /**
   * @param Filter $filter
   */
  public function filter(Filter $filter)
  {
    $result = $this->check($filter);
    // 调用下一个对象
    if (!empty($this->nextHandler)) {
       $this->nextHandler->filter($filter);
    }
    return $result;
  }

}
