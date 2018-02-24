<?php
/**
 * 发送消息.
 */
use Slince\SmartQQ\Client;
use Slince\SmartQQ\Message\Request\FriendMessage;
use Slince\SmartQQ\Message\Request\GroupMessage;
use Slince\SmartQQ\Message\Request\DiscussMessage;
use Slince\SmartQQ\Message\Content;

include __DIR__.'/bootstrap.php';

//创建smartQQ客户端
$smartQQ = new Client(getCredential());

$friends = $smartQQ->getFriends();
$groups = $smartQQ->getGroups();
$discusses = $smartQQ->getDiscusses();
//# 给好友发送消息

//1、找到好友
$friend = $friends->firstByAttribute('nick', '秋易');
//2、生成消息
//支持表情，使用中括号括起来即可，表情短语
/**
 * [.
"微笑" ,"撇嘴" ,"色" ,"发呆" ,"得意" ,"流泪" ,"害羞" ,"闭嘴" ,"睡" ,"大哭" ,"尴尬" ,"发怒" ,"调皮" ,"呲牙" ,"惊讶" ,"难过" ,"酷" ,"冷汗" ,"抓狂" ,"吐",
"偷笑" ,"可爱" ,"白眼" ,"傲慢" ,"饥饿" ,"困" ,"惊恐" ,"流汗" ,"憨笑" ,"大兵" ,"奋斗" ,"咒骂" ,"疑问" ,"嘘" ,"晕" ,"折磨" ,"衰" ,"骷髅" ,"敲打" ,"再见",
"擦汗" ,"抠鼻" ,"鼓掌" ,"糗大了" ,"坏笑" ,"左哼哼" ,"右哼哼" ,"哈欠" ,"鄙视" ,"委屈" ,"快哭了" ,"阴险" ,"亲亲" ,"吓" ,"可怜" ,"菜刀" ,"西瓜" ,"啤酒" ,"篮球" ,"乒乓",
"咖啡" ,"饭" ,"猪头" ,"玫瑰" ,"凋谢" ,"示爱" ,"爱心" ,"心碎" ,"蛋糕" ,"闪电" ,"炸弹" ,"刀" ,"足球" ,"瓢虫" ,"便便" ,"月亮" ,"太阳" ,"礼物" ,"拥抱" ,"强",
"弱" ,"握手" ,"胜利" ,"抱拳" ,"勾引" ,"拳头" ,"差劲" ,"爱你" ,"NO" ,"OK" ,"爱情" ,"飞吻" ,"跳跳" ,"发抖" ,"怄火" ,"转圈" ,"磕头" ,"回头" ,"跳绳" ,"挥手",
"激动", "街舞", "献吻", "左太极", "右太极", "双喜", "鞭炮", "灯笼", "发财", "K歌", "购物", "邮件", "帅", "喝彩","祈祷","爆筋","棒棒糖","喝奶","下面","香蕉",
"飞机","开车","左车头","车厢","右车头","多云","下雨","钞票","熊猫","灯泡","风车","闹钟","打伞","彩球","钻戒","沙发","纸巾","药","手枪","青蛙"
]
 */
$message = new FriendMessage($friend, new Content('[大哭]你好[左哼哼]'));
$result = $smartQQ->sendMessage($message);
printR($result ? 'Send Success' : 'Send Error');

//# 给群发送消息
//1、找到群
$group = $groups->firstByAttribute('name', 'msu');
//2、生成消息
$message = new GroupMessage($group, new Content('哈喽'));
$result = $smartQQ->sendMessage($message);
printR($result ? 'Send Success' : 'Send Error');

//# 发送讨论组消息
//1、找到讨论组
$discuss = $discusses->firstByAttribute('name', '他是个少年');
//2、生成消息
$message = new DiscussMessage($discuss, '讨论组消息');
$result = $smartQQ->sendMessage($message);
printR($result ? 'Send Success' : 'Send Error');

//# 给讨论组成员发消息
$discussMember = $smartQQ->getDiscussDetail($discuss)
    ->getMembers()
    ->firstByAttribute('nick', '张三');
$message = new FriendMessage($discussMember, '你好');
$result = $smartQQ->sendMessage($message);
printR($result ? 'Send Success' : 'Send Error');

//# 给群成员发送消息
/*
$groupMember = $smartQQ->getGroupDetail($group)
    ->getMembers()
    ->firstByAttribute('nick', '清延°');
$message = new FriendMessage($discussMember,  '你好');
$result = $smartQQ->sendMessage($message);
printR($result ? 'Send Success' : 'Send Error');
*/