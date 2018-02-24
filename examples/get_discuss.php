<?php
/**
 * 获取讨论组相关信息.
 */
use Slince\SmartQQ\Client;

include __DIR__.'/bootstrap.php';

//创建smartQQ客户端
$smartQQ = new Client(getCredential());

//# 讨论组

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