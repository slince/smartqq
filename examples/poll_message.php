<?php
/**
 * 获取消息
 */
use Slince\SmartQQ\Client;
use Slince\SmartQQ\Message\Response\FriendMessage;
use Slince\SmartQQ\Message\Response\GroupMessage;
use Slince\SmartQQ\Message\Response\DiscussMessage;

include __DIR__ . '/bootstrap.php';

//创建smartQQ客户端
$smartQQ = new Client(getCredential());

while (true) {
    $messages = $smartQQ->pollMessages();
    if ($messages) {
        printR("收到消息" . PHP_EOL);
        foreach ($messages as $message) {
            if ($message instanceof FriendMessage) {
                $content = sprintf("好友[%s] -- %s: \r\n %s", $message->getFriend());
            }
        }
    }
}