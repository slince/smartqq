<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Message\Request\GroupMessage;

class SendGroupMessageRequest extends SendMessageRequest
{
    protected $uri = 'http://d1.web2.qq.com/channel/send_qun_msg2';

    protected $referer = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    public function __construct(GroupMessage $message, Credential $credential)
    {
        $parameters = array_merge([
            'group_uin' => $message->getGroup()->getId()
        ], $this->makeMessageParameter($message, $credential));
        $this->setParameter('r', \GuzzleHttp\json_encode($parameters));
    }
}
