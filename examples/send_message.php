<?php
/**
 * 发送消息
 */
use Slince\SmartQQ\Client;
use Slince\SmartQQ\Message\Request\FriendMessage;
use Slince\SmartQQ\Message\Request\GroupMessage;
use Slince\SmartQQ\Message\Request\DiscussMessage;
use Slince\SmartQQ\Message\Content;

include __DIR__ . '/bootstrap.php';

//创建smartQQ客户端
$smartQQ = new Client(getCredential());

$friends = $smartQQ->getFriends();
$groups = $smartQQ->getGroups();
$discusses = $smartQQ->getDiscusses();
## 给好友发送消息

//1、找到好友
$friend = $friends->firstByAttribute('nick', '秋易');
//2、生成消息
$message = new FriendMessage($friend, new Content('你好'));
$result = $smartQQ->sendMessage($message);
printR($result ? 'Send Success' : 'Send Error');

## 给群发送消息
//1、找到群
$group = $groups->firstByAttribute('name', 'msu');
//2、生成消息
$message = new GroupMessage($group, new Content('哈喽'));
$result = $smartQQ->sendMessage($message);
printR($result ? 'Send Success' : 'Send Error');


## 发送讨论组消息
//1、找到讨论组
$discuss = $discusses->firstByAttribute('name', '他是个少年');
//2、生成消息
$message = new DiscussMessage($discuss, '讨论组消息');
$result = $smartQQ->sendMessage($message);
printR($result ? 'Send Success' : 'Send Error');

## 给讨论组成员发消息
$discussMember = $smartQQ->getDiscussDetail($discuss)
    ->getMembers()
    ->firstByAttribute('nick', '张三');
$message = new FriendMessage($discussMember, '你好');
$result = $smartQQ->sendMessage($message);
printR($result ? 'Send Success' : 'Send Error');

## 给群成员发送消息
/*
$groupMember = $smartQQ->getGroupDetail($group)
    ->getMembers()
    ->firstByAttribute('nick', '清延°');
$message = new FriendMessage($discussMember,  '你好');
$result = $smartQQ->sendMessage($message);
printR($result ? 'Send Success' : 'Send Error');
*/