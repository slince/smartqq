<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Message\Request\DiscussMessage;

class SendDiscusMessageRequest extends SendMessageRequest
{
    protected $uri = 'http://d1.web2.qq.com/channel/send_discu_msg2';

    public function __construct(DiscussMessage $message, Credential $credential)
    {
        $parameters = array_merge([
            'did' => $message->getDiscuss()->getId(),
        ], $this->makeMessageParameter($message, $credential));
        $this->setParameter('r', \GuzzleHttp\json_encode($parameters));
    }
}
