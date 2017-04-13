<?php
/**
 * 获取当前登录用户的信息
 */
use Slince\SmartQQ\Client;

include __DIR__ . '/bootstrap.php';

//创建smartQQ客户端
$smartQQ = new Client(getCredential());


$friend = $smartQQ->getFriends()->first();

//获取用户的个性签名
$lnick = $smartQQ->getFriendLnick($friend);

printR($lnick);