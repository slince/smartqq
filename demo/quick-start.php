<?php
use Slince\SmartQQ\SmartQQ;

include __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Prc');

$smartQQ = new SmartQQ();

//先登录
$qrImage = __DIR__ . '/qrcode.png'; //二维码存放位置
$smartQQ->login($qrImage);

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

try {
//获取最近消息
    $recents = $smartQQ->getRecentList();
    logResult("RecentList:\r\n");
    logResult($recents);
}catch (\Exception $e) {
    
}

//发送消息给讨论组
$result = $smartQQ->sendMessageToDiscus($discuses[0]->id, "Test Discus Message");
var_dump($result);

//发送消息给群
$result = $smartQQ->sendMessageToGroup($groups[0]->id, "Test Group Message");
var_dump($result);

//发送消息给好友
$result = $smartQQ->sendMessageToFriend($friends[2]->uin, "Test Friend Message");
var_dump($result);
/**
 * 记录返回结果
 * @param $result
 */
function logResult($result)
{
    @file_put_contents(getcwd() . '/result.log', print_r($result, true) . "\r\n", FILE_APPEND);
}
