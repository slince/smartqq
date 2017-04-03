<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Message\Request\FriendMessage;

class SendFriendMessageRequest extends SendMessageRequest
{
    protected $uri = 'http://d1.web2.qq.com/channel/send_buddy_msg2';

    protected $referer = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    public function __construct(FriendMessage $message, Credential $credential)
    {
        $parameters = array_merge([
            'to' => $message->getUser()->getUin()
        ], $this->makeMessageParameter($message, $credential));
        $this->setParameter('r', \GuzzleHttp\json_encode($parameters));
    }
}
