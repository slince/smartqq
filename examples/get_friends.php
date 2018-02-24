<?php
/**
 * 获取好友相关信息.
 */
use Slince\SmartQQ\Client;

include __DIR__.'/bootstrap.php';

//创建smartQQ客户端
$smartQQ = new Client(getCredential());

//# 好友相关

//1、获取所有好友
$friends = $smartQQ->getFriends();

//2、从好友中筛选出指定好友，
/**
 * 注意QQ号需要单独发起请求查询QQ号，故如果需要按照QQ号筛选，需要做好心里准备
 * smartqq会多次发起请求
 */
$friend = $friends->firstByAttribute('nick', '清延°');

//3、获取好友的详细信息
$profile = $smartQQ->getFriendDetail($friend);

//4、获取好友的真实QQ号（此接口目前已经被腾讯封禁）
//$qq = $smartQQ->getFriendQQ($friend);

//3、输出结果
printPrettyScreen($friends->toArray());
printR($friend);
printR($profile);
//printR($qq);
