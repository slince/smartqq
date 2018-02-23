# SmartQQ协议

[![Build Status](https://img.shields.io/travis/slince/smartqq/master.svg?style=flat-square)](https://travis-ci.org/slince/smartqq)
[![Coverage Status](https://img.shields.io/codecov/c/github/slince/smartqq.svg?style=flat-square)](https://codecov.io/github/slince/smartqq)
[![Latest Stable Version](https://img.shields.io/packagist/v/slince/smartqq.svg?style=flat-square&label=stable)](https://packagist.org/packages/slince/smartqq)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/slince/smartqq.svg?style=flat-square)](https://scrutinizer-ci.com/g/slince/smartqq/?branch=master)

SmartQQ(WebQQ) API的PHP实现，通过对原生web api的请求以及返回值的分析，重新进行了整理；
解决了原生接口杂乱的请求规则与混乱的数据返回；使得开发者可以更多关注自己的业务。

灵感来自于[Java SmartQQ](https://github.com/ScienJus/smartqq)，感谢原作者对SmartQQ的详尽解释。

## 安装

```bash
composer require slince/smartqq
```

## 使用

### 登录

登录是获取授权的必备步骤，由于SmartQQ抛弃了用户名密码的登录方式，所以只能采用二维码登录

```php
use Slince\SmartQQ\Client;

$smartQQ = new Client();

$smartQQ->login('/path/to/qrcode.png'); //参数为保存二维码的位置
```
如果成功的话你会在`/path/to/qrcode.png`下发现二维码，使用手机扫描即可登录；注意：程序会阻塞直到确认成功；成功之后你可以通过下面方式持久化登录凭证，用于下次查询。

```php
$credential = $smartQQ->getCredential();
$credentialParameters = $credential->toArray();
```

通过下面方式还原一个凭证对象；需要注意的是此次凭证并不会长久有效，如果该凭证长时间没有被用来发起查询，则很可能会失效

```php
//还原凭证对象
$credential = Credential::fromArray($credentialParameters);
$smartQQ = new Client($credential);
```

### 查询好友、群以及讨论组

#### 好友相关

- 查询所有好友

```php
$friends = $smartQQ->getFriends();

//找出昵称为张三的好友
$zhangSan = $friends->firstByAttribute('nick', '张三');

//自定义筛选，如找出所有女性并且是vip会员的好友
$girls = $friends->filter(function(Friend $friend){
     return $friend->getGender() == 'female' && $friend->isVip();
})->toArray();
```

- 查询好友详细资料

```php
//上例，找出张三的资料
$profile = $smartQQ->getFriendDetail($zhangSan);
```

#### 群相关

- 查询所有群

```php
$groups = $smartQQ->getGroups();

//找出名称为“少年”的群
$shaoNianGroup = $groups->firstByAttribute('name', '少年');
```
> 同样支持自定义筛选

#### 讨论组相关

- 查询所有讨论组

```php
$discusses = $smartQQ->getDiscusses();

//找出名称为“少年”的讨论组
$shaoNianDiscuss = $discusses->firstByAttribute('name', '少年');
```
> 一样，也支持自定义筛选


- 查询讨论组的详细资料，比如群成员信息等

接上例，查询讨论组“少年”的详细资料

```php
$shaoNianDetail = $smartQQ->getDiscussDetail($shaoNianDiscuss);

//所有群成员，支持自定义筛选
$members = $shaoNianDetail->getMembers();
```

### 发送消息

支持表情，表情短语

```php
[
"微笑" ,"撇嘴" ,"色" ,"发呆" ,"得意" ,"流泪" ,"害羞" ,"闭嘴" ,"睡" ,"大哭" ,"尴尬" ,"发怒" ,"调皮" ,"呲牙" ,"惊讶" ,"难过" ,"酷" ,"冷汗" ,"抓狂" ,"吐",
"偷笑" ,"可爱" ,"白眼" ,"傲慢" ,"饥饿" ,"困" ,"惊恐" ,"流汗" ,"憨笑" ,"大兵" ,"奋斗" ,"咒骂" ,"疑问" ,"嘘" ,"晕" ,"折磨" ,"衰" ,"骷髅" ,"敲打" ,"再见",
"擦汗" ,"抠鼻" ,"鼓掌" ,"糗大了" ,"坏笑" ,"左哼哼" ,"右哼哼" ,"哈欠" ,"鄙视" ,"委屈" ,"快哭了" ,"阴险" ,"亲亲" ,"吓" ,"可怜" ,"菜刀" ,"西瓜" ,"啤酒" ,"篮球" ,"乒乓",
"咖啡" ,"饭" ,"猪头" ,"玫瑰" ,"凋谢" ,"示爱" ,"爱心" ,"心碎" ,"蛋糕" ,"闪电" ,"炸弹" ,"刀" ,"足球" ,"瓢虫" ,"便便" ,"月亮" ,"太阳" ,"礼物" ,"拥抱" ,"强",
"弱" ,"握手" ,"胜利" ,"抱拳" ,"勾引" ,"拳头" ,"差劲" ,"爱你" ,"NO" ,"OK" ,"爱情" ,"飞吻" ,"跳跳" ,"发抖" ,"怄火" ,"转圈" ,"磕头" ,"回头" ,"跳绳" ,"挥手",
"激动", "街舞", "献吻", "左太极", "右太极", "双喜", "鞭炮", "灯笼", "发财", "K歌", "购物", "邮件", "帅", "喝彩","祈祷","爆筋","棒棒糖","喝奶","下面","香蕉",
"飞机","开车","左车头","车厢","右车头","多云","下雨","钞票","熊猫","灯泡","风车","闹钟","打伞","彩球","钻戒","沙发","纸巾","药","手枪","青蛙"
]
```

#### 给好友发送消息

```php
//1、找到好友
$friend = $friends->firstByAttribute('nick', '秋易');

//2、生成消息
$message = new FriendMessage($friend, '[微笑] 你好');
$result = $smartQQ->sendMessage($message);
var_dump($result);
```

#### 给群发送消息

```php
//1、找到群
$group = $groups->firstByAttribute('name', 'msu');
//2、生成消息
$message = new GroupMessage($group, new Content('[微笑] 哈喽'));
$result = $smartQQ->sendMessage($message);
var_dump($result);
```

#### 发送讨论组消息

```php
//1、找到讨论组
$discuss = $discusses->firstByAttribute('name', '他是个少年');
//2、生成消息
$message = new DiscussMessage($discuss, '[微笑] 讨论组消息');
$result = $smartQQ->sendMessage($message);
var_dump($result);
```

#### 给讨论组成员发消息

```php
$discussMember = $smartQQ->getDiscussDetail($discuss)
    ->getMembers()
    ->firstByAttribute('nick', '张三');
$message = new FriendMessage($discussMember,  '[微笑] 你好');
$result = $smartQQ->sendMessage($message);
var_dump($result);
```

### 接收消息

```php
$messages = $smartQQ->pollMessages();
```
关于消息的处理请参照examples


详细使用案例以及更多其它案例请参考[examples](./examples)

## 其它

- 关于103错误，多是由于webqq多点登录引起的，如果遇到错误，先到[http://w.qq.com/](http://w.qq.com/)确认能够收发消息，然后退出登录。

- 关于登录凭证的时效性，smartqq是基于web接口的，对cookie有要求，登录成功之后如果长时间没有操作，cookie将会失效；此时需要重新登录。

- 本组件只是对原生的请求与数据进行了整理并进行了合理的抽象，并没有过多的进行业务层级的封装。

- SmartQQ接口一直在调整，如果api无法使用请直接提[issue](https://github.com/slince/smartqq/issues/new)，或者给我发邮件。