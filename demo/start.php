<?php
use Slince\SmartQQ\SmartQQ;
include __DIR__ . '/../vendor/autoload.php';

$smartQQ = new SmartQQ();

//先登录
$qrImage = __DIR__ . '/qrcode.png'; //二维码存放位置
$smartQQ->login($qrImage);

//获取当前信息
$loginInfo = $smartQQ->getLoginInfo();
print_r($loginInfo);

