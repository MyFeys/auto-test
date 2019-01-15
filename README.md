# c2498168786/auto-test

## 背景
- 别人改了先前接口，如果造成有功能影响，你可能不会发现
- 当你修改了比较底层的东西，可能影响范围比较大，需要大量时间回归测试。
- 针对有些重复机械的测试工作，浪费了大量的人力和物力，测试的结果也不太准确

基于swagger-php的自动化测试工具，仅需要指定对应swagger.json文件，不仅可以解决以上问题还可生成如下几种报告策略

- Screen        屏幕输出，将测试结果打印在终端或控制台
- Email         邮件通知，将测试报告以邮件形式发送到指定邮箱，该策略需要简单的邮件配置

## 两种方式安装

autoTest是基于php的，采用composer安装，所以需要安装php运行环境和composer包管理工具；php最低版本要求5.5.9
- 安装扩展包
composer global require c2498168786/auto-test
- 或者直接下载下来当成一个单独项目
Git clone https://github.com/c2498168786/auto-test.git
两种方式都需要安装对应依赖包哦 composer install


## 执行

php autoTest [swagger.json文件] [生成报告策略]
