# 机械师

基于php的测试框架，目前支持api接口测试

## 安装

Mechanic是基于php的，采用composer安装，所以需要安装php运行环境和composer包管理工具；php最低版本要求5.5.9，如需要帮助请参考
[php官网](http://php.net/), [windows平台官网](http://windows.php.net/);如果您没有安装composer请先安装composer，参考链接
[composer官网](https://getcomposer.org)，[composer中文网](http://www.phpcomposer.com/)
环境准备完毕之后在命令行或者终端执行以下命令安装

```
composer global require slince/mechanic *@dev
```

安装完成之后执行
```
mechanic --help
```

验证是否安装成功，如果提示你命令不存在那么你需要将composer的全局bin目录加入到系统路径

## 使用

### 创建测试项目

执行项目创建命令
```
mechanic new-project [name]
```
执行完毕之后你会在当前目录下看到以[name]命名的项目

### 创建测试用例

- Mechanic基于php，所以意味着你需要一些php语言的编程能力，当然常用语法并不复杂
- 在项目目录`/src/TestCase`下创建测试用例，测试用例需要继承`Slince\Mechanic\TestCase\ApiTestCase`
- 编写测试方法，测试方法需要以test开头写在测试用例里；详细实例请参考demo

### 创建测试套件
在项目目录`/src/TestSuite`下创建测试套件文件，详细实例请参考demo
测试套件是可选的，如果你没有创建测试套件，mechanic会创建一个default测试套件，并将所有的测试用例加入该测试套件

### 执行测试套件
```
mechanic run [project] --suite TestSuiteName1 --suite TestSuiteName2
```
project是可选的，如果不提供测默认当前目录是测试项目路径

### 查看测试报告
Mechanic支持以下几种报告策略：

- Excel，最基本的测试报告，执行完毕之后你可以在测试项目`/reports`看到测试报告
- PDF， 与excel类似，报告在`/reports`下面查看，由于测试报告效果并不理想，暂时不可用
- EmailNotification， 邮件通知，将测试报告以邮件形式发送到指定邮箱，该策略需要简单的邮件配置
- ScreenPretty， 屏幕输出，将测试结果打印在终端或控制台，由于篇幅问题，测试套件的信息需要你与控制台交互

你可以将Mechanic与Jenkins结合实现全自动化测试，详细情况参考文章[Mechanic于Jenkins结合实现无人值守自动化运行](http://www.qimuyu.com/posts/49)