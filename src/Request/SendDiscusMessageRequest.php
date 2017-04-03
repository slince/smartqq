<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Message\Request\DiscussMessage;

class SendDiscusMessageRequest extends SendMessageRequest
{
    protected $uri = 'http://d1.web2.qq.com/channel/send_discu_msg2';

    protected $referer = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    public function __construct(DiscussMessage $message, Credential $credential)
    {
        $parameters = array_merge([
            'did' => $message->getDiscuss()->getId()
        ], $this->makeMessageParameter($message, $credential));
        $this->setParameter('r', \GuzzleHttp\json_encode($parameters));
    }
}
