<?php

/**
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
return [
    // Supported: "smtp", "mail", "sendmail", "mailgun", "mandrill", "ses", "log"
    'driver' => 'smtp',
    'host' => '',
    'port' => 25,
    'from' => ['address' => '', 'name' => '自动化测试报告通知'],
    'encryption' => '', // 暂时去掉ssl认证
    'username' => '',
    'password' => '',
    
    'subject' => '某项目的自动化测试报告',
    'receiver' => ['2498168786@qq.com']
];