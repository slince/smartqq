<?php
use Slince\SmartQQ\Client;

include __DIR__ . '/bootstrap.php';

//创建smartQQ客户端
$smartQQ = new Client(getCredential());

//获取所有好友
$friends = $smartQQ->getFriends();
printPrettyScreen($friends->toArray());

//获取所有群
$groups = $smartQQ->getGroups();
//printPrettyScreen($groups->toArray());

//获取所有讨论组
$discusses = $smartQQ->getDiscusses();
printPrettyScreen($discusses->toArray());