<?php
namespace AutoTest\Exception;

/**
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
class InvalidException extends \Exception
{
    public function  __construct($message, $code = 0)
    {
//        parent::__construct($message, $code);
    }

    public function  __toString ()
    {
//        return  __CLASS__ . ":[{$this->code}]:{$this->message}\n";
    }
}