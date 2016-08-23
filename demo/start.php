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
logResult($friends);

//获取群
$groups = $smartQQ->getGroups();
logResult($groups);

//获取讨论组
$discuses = $smartQQ->getDiscuses();
logResult($discuses);

//发送消息给好友
$result = $smartQQ->sendMessageToFriend('1582213624', "Test Message");
var_dump($result);
/**
 * 记录返回结果
 * @param $result
 */
function logResult($result)
{
    @file_put_contents(getcwd() . '/result.log', print_r($result, true) . "\r\n", FILE_APPEND);
}
