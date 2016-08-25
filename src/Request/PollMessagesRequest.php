<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Exception\RuntimeException;
use Slince\SmartQQ\Model\Font;
use Slince\SmartQQ\Model\Message;
use Slince\SmartQQ\UrlStore;

class PollMessagesRequest extends AbstractRequest
{
    protected $url = UrlStore::POLL_MESSAGES;

    protected $referer = UrlStore::POLL_MESSAGES_REFERER;

    protected $requestMethod = RequestInterface::REQUEST_METHOD_POST;

    /**
     * 解析响应数据
     * @param Response $response
     * @return Message[]
     */
    public function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0 && isset($jsonData['result'])) {
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
        }
        throw new RuntimeException("Response Error");
    }
}
