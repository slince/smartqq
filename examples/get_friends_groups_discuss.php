<?php
/**
 * 获取好友、群、讨论组相关信息
 */
use Slince\SmartQQ\Client;

include __DIR__ . '/bootstrap.php';

//创建smartQQ客户端
$smartQQ = new Client(getCredential());


## 好友相关

//1、获取所有好友
$friends = $smartQQ->getFriends();

//2、从好友中筛选出指定好友，
/**
 * 注意QQ号需要单独发起请求查询QQ号，故如果需要按照QQ号筛选，需要做好心里准备
 * smartqq会多次发起请求
 */
$friend = $friends->firstByAttribute('nick', '流浪星');

//获取好友的详细信息
$profile = $smartQQ->getFriendDetail($friend);

//3、输出结果
printPrettyScreen($friends->toArray());
printR($friend);
printR($profile);



## 群信息

//1、获取所有群
$groups = $smartQQ->getGroups();

//2、筛选出指定的群
$group = $groups->firstByAttribute('name', 'sheinside商城');

//3、获取群的详细信息
//$groupDetail = $smartQQ->getGroupDetail($group);
//printR($groupDetail);
// 输出
printPrettyScreen($groups->toArray());
printR($group);


## 讨论组

//1、获取所有讨论组
$discusses = $smartQQ->getDiscusses();

//2、获取指定讨论组的详细信息
$firstDiscuss = $discusses->first();
$discussDetail = $smartQQ->getDiscussDetail($firstDiscuss);

$discussMembers = $discussDetail->getMembers(); //讨论组下的所有成员


printPrettyScreen($discusses->toArray());
printPrettyScreen($discussMembers->toArray());
printR($firstDiscuss);
printR($discussDetail);