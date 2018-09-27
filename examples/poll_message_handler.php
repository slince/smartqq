<?php
/**
 * 使用 message handler.
 */
use Slince\SmartQQ\Client;
use Slince\SmartQQ\Message\Response\FriendMessage;
use Slince\SmartQQ\Message\Response\GroupMessage;
use Slince\SmartQQ\Message\Response\DiscussMessage;
use Slince\SmartQQ\Entity\Discuss;
use Slince\SmartQQ\Entity\DiscussDetail;

include __DIR__.'/bootstrap.php';

//创建smartQQ客户端
$smartQQ = new Client(getCredential());
$friends = $smartQQ->getFriends();
$groups = $smartQQ->getGroups();
$discusses = $smartQQ->getDiscusses();

/**
 * 获取讨论组详情.
 *
 * @param Discuss $discuss
 *
 * @return DiscussDetail
 */
function getDiscussDetails(Discuss $discuss)
{
    global $smartQQ;
    static $discussDetails = [];
    if (isset($discussDetails[$discuss->getId()])) {
        return $discussDetails[$discuss->getId()];
    }

    return $discussDetails[$discuss->getId()] = $smartQQ->getDiscussDetail($discuss);
}

$handler = $smartQQ->getMessageHandler();

$handler->onMessage(function($message) use ($friends, $groups, $discusses){

    if ($message instanceof FriendMessage) {
        $friend = $friends->firstByAttribute('uin', $message->getFromUin());
        $content = sprintf("好友[%s] -- %s: \r\n %s",
            $friend->getNick(),
            date('H:i:s'),
            $message
        );
    } elseif ($message instanceof GroupMessage) {
        $group = $groups->firstByAttribute('id', $message->getFromUin());
        $content = sprintf("群[%s] -- %s: \r\n %s",
            $group->getName(),
            date('H:i:s'),
            $message
        );
    } elseif ($message instanceof DiscussMessage) {
        $discuss = $discusses->firstByAttribute('id', $message->getFromUin());
        $sender = getDiscussDetails($discuss)->getMembers()->firstByAttribute('uin', $message->getSendUin());
        $content = sprintf("讨论组[%s] [%s]-- %s: \r\n %s",
            $discuss->getName(),
            $sender->getNick(),
            date('H:i:s'),
            $message
        );
    } else {
        exit('不支持的消息类型');
    }

    printR('收到消息'.PHP_EOL);
    printR($content);
    echo str_repeat(PHP_EOL, 2);
});

$handler->listen();