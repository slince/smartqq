<?php
use Slince\SmartQQ\Client;

include __DIR__ . '/bootstrap.php';

//创建smartQQ客户端
$smartQQ = new Client();

//登录获取授权
$smartQQ->login(LOGIN_QR_IMAGE);
//执行之后你会在[LOGIN_QR_IMAGE]对应的位置发现二维码图片； 获取授权的时候程序会锁住直到二维码确认成功；
saveCredential($smartQQ->getCredential());