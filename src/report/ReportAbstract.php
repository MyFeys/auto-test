<?php
namespace AutoTest\Report;
/**
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
abstract class ReportAbstract
{
    public $data;

    // 生成报告
    public abstract function generate();
}