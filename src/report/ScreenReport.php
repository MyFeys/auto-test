<?php
namespace AutoTest\Report;

/**
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
class ScreenReport extends ReportAbstract
{
    public function generate()
    {
        $this->data = is_array($this->data) ? $this->data : ['request' => $this->data, 'response' => $this->data];
        foreach ($this->data as $item) {
            echo $item['request']."\n";
            echo htmlspecialchars($item['response'], ENT_QUOTES, 'UTF-8')."\n";
        }
    }
    
}
