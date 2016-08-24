# SmartQQ协议

SmartQQ(WebQQ) API的PHP实现，灵感来自于[Java SmartQQ](https://github.com/ScienJus/smartqq)，感谢原作者对SmartQQ的详尽解释。

## 安装
```
composer require slince/smartqq *@dev
```

## 使用

- 登录，由于SmartQQ抛弃了用户名密码的登录方式，所以只能采用二维码登录
```
use Slince\SmartQQ\SmartQQ;

$smartQQ = new SmartQQ();

$smartQQ->login('/path/to/qrcode.png'); //参数为保存二维码的位置
```
如果成功的话你会在`/path/to/qrcode.png`下发现二维码，拿出手机扫一扫即可登录；注意在登录成功之前程序会锁住

- 相关查询
```
//获取好友列表
$friends = $smartQQ->getUserFriends();
logResult("Friends:\r\n");
logResult($friends);
//获取好友详情
$friend = $smartQQ->getFriendDetail($friends[0]->uin);
logResult("FriendDetail:\r\n");
logResult($friend);

//获取群
$groups = $smartQQ->getGroups();
logResult("Groups:\r\n");
logResult($groups);
//获取群信息
$group = $smartQQ->getGroupDetail($groups[0]->code);
logResult("GroupDetail:\r\n");
logResult($group);

//获取讨论组
$discuses = $smartQQ->getDiscuses();
logResult("Discuses:\r\n");
logResult($discuses);
//获取讨论组信息
$discus = $smartQQ->getDiscusDetail($discuses[0]->id);
logResult("DiscusDetail:\r\n");
logResult($discus);
```
- 收发消息
```
//发送消息给讨论组
$result = $smartQQ->sendMessageToDiscus($discuses[0]->id, "Test Discus Message");
var_dump($result);

//发送消息给群
$result = $smartQQ->sendMessageToGroup($groups[0]->id, "Test Group Message");
var_dump($result);

//发送消息给好友
$result = $smartQQ->sendMessageToFriend($friends[2]->uin, "Test Friend Message");
var_dump($result);

//循环消息
logResult("Loop Message:\r\n");
while (true) {
    $messages = $smartQQ->pollMessages();
    if ($messages) {
        logResult($messages);
        print_r($messages);
    } else {
        sleep(2);
    }
}
```

完整的使用用例请参考[QuickStart](./doc/quick-start.php)