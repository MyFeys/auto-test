<?php
namespace AutoTest\Report;
/**
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-10
 * @copyright arrayhua.github.io
 */
class Report
{
    private $strategy;   // 执行哪种策略
    public $data;

    /**
     * Report constructor.
     * @param ReportAbstract $strategy 策略实例
     */
    public function __construct(ReportAbstract $strategy)
    {
        $this->strategy = $strategy;
    }
    
    public function generate()
    {
        $this->strategy->data = $this->data;
        $this->strategy->generate();
    }
}