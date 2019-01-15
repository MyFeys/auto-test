<?php
namespace AutoTest;


/**
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
class Application
{
    private static $instance;

    private function __construct(){}

    public static function run()
    {
        self::$instance = self::getInstance();
        
//        $argv = $_SERVER['argv'];
//        array_shift($argv);
//        (new Router())->single($argv);
        (new Router())->single();
    }

    public static function getInstance()
    {
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
}