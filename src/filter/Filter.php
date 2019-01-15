<?php
namespace AutoTest\Filter;

/*
 * 过滤对象
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-08
 * @copyright arrayhua.github.io
 */
use AutoTest\Lib\Http;
use AutoTest\Lib\SwaggerAnalyze;

class Filter
{
    public $passTags = [];      // 可以指定只测试一些类别
    public $noPassTags = [];    // 可以指定排除一些类别
    public $passMethods = [];   // 可以指定只测试一些方法
    public $noPassMethods = []; // 可以指定排除一些方法

    /**
     * @var Http $http;
     */
    public $http;
    /**
     * @var SwaggerAnalyze $swagger;
     */
    public $swagger;            // swagger内容
    public $currentPathKey;     // 当前uri
    public $currentPathTags;    // 当前中标签
    public $currentPath;        // 当前Path(请求信息和返回信息在里面)
    public $currentUrl;         // 当前发起请求的url
    public $currentParams;      // 当前发起请求的参数Params

    
}
