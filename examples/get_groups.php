<?php
/**
 * 获取群相关信息.
 */
use Slince\SmartQQ\Client;

include __DIR__.'/bootstrap.php';

//创建smartQQ客户端
$smartQQ = new Client(getCredential());

//# 群信息

//1、获取所有群
$groups = $smartQQ->getGroups();

//2、筛选出指定的群
$group = $groups->firstByAttribute('name', 'Symfony.cn');

//3、获取群的详细信息
$groupDetail = $smartQQ->getGroupDetail($group);
// 输出
printPrettyScreen($groups->toArray());
printR($group);
printR($group);
printR($groupDetail);
