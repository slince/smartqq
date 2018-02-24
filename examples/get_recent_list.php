<?php
/**
 * 获取最新的会话记录,.
 */
use Slince\SmartQQ\Client;

include __DIR__.'/bootstrap.php';

//创建smartQQ客户端
$smartQQ = new Client(getCredential());

//获取当前登录的用户
$recentList = $smartQQ->getRecentList();

printR($recentList->toArray());