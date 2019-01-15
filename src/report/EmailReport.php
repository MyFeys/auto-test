<?php
namespace AutoTest\Report;

use AutoTest\Lib\Email;

/**
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
class EmailReport extends ReportAbstract
{
    
    public function generate()
    {
        $str = '';
        if (is_array($this->data)) {
            foreach ($this->data as $item) {
                $str .= ($item['request']."<br/>".$item['response']."<br/><br/>");
            }
        } else {
            $str = $this->data;
        }
        $email = (new Email());
        $email->body = $str;

        $email->sendMail();
    }
}
