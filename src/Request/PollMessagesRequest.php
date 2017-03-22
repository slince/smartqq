<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Exception\Code103ResponseException;
use Slince\SmartQQ\Exception\ResponseException;
use Slince\SmartQQ\Model\Font;
use Slince\SmartQQ\Model\Message;

class PollMessagesRequest extends Request
{
    protected $uri = 'http://d1.web2.qq.com/channel/poll2';

    protected $referer = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    protected $method = RequestInterface::REQUEST_METHOD_POST;

    public function __construct(Credential $credential)
    {
        $this->setParameter('r', \GuzzleHttp\json_encode([
            'ptwebqq' => $credential->getPtWebQQ(),
            'clientid' => $credential->getClientId(),
            'psessionid' => $credential->getPSessionId(),
            'key' => ''
        ]));
    }

    /**
     * 解析响应数据
     * @param Response $response
     * @return Message[]
     */
    public function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0) {
            $messages = [];
            foreach ($jsonData['result'] as $messageData) {
                $message = [
                    'id' => $messageData['value']['msg_id'],
                    'type' => $messageData['poll_type'],
                    'content' => $messageData['value']['content'][1],
                    'font' => new Font($messageData['value']['content'][0][1]),
                    'fromUin' => $messageData['value']['from_uin'],
                    'toUin' => $messageData['value']['to_uin'],
                    'time' => $messageData['value']['time'],
                ];
                if ($messageData['poll_type'] == Message::TYPE_GROUP) {
                    $message['groupCode'] = $messageData['value']['group_code'];
                    $message['sendUin'] = $messageData['value']['send_uin'];
                } elseif ($messageData['poll_type'] == Message::TYPE_DISCUS) {
                    $message['discusId'] = $messageData['value']['did'];
                    $message['sendUin'] = $messageData['value']['send_uin'];
                }
                $messages[] = new Message($message);
            }
            return $messages;
        } elseif ($jsonData['retcode'] == 103) {
            throw new Code103ResponseException();
        }
        throw new ResponseException("Response Error");
    }
}
