<?php
/**
 * 获取好友QQ号.
 */
use Slince\SmartQQ\Client;

include __DIR__.'/bootstrap.php';

//创建smartQQ客户端
$smartQQ = new Client(getCredential());

$friend = $smartQQ->getFriends()->first();

//获取用户的QQ号
$qq = $smartQQ->getFriendQQ($friend);

printR($qq);
printR($friend->getQq());