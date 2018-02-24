<?php
/**
 * 获取当前登录用户的信息.
 */
use Slince\SmartQQ\Client;

include __DIR__.'/bootstrap.php';

//创建smartQQ客户端
$smartQQ = new Client(getCredential());

//获取当前登录的用户
$user = $smartQQ->getCurrentUserInfo();

printR($user);