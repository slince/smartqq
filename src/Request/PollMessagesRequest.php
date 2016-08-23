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
    function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0) {
            $messages = [];
            foreach ($jsonData['result'] as $messageData) {
                $message = [
                    'id' => $messageData['msg_id'],
                    'type' => $messageData['poll_type'],
                    'message' => $messageData['value']['content'][1],
                    'font' => new Font($messageData['value']['content'][0][1]),
                    'fromUin' => $messageData['from_uin'],
                    'sendUin' => $messageData['send_uin'],
                    'toUin' => $messageData['to_uin'],
                    'time' => $messageData['time'],
                ];
                if ($messageData['poll_type'] == Message::TYPE_GROUP) {
                    $message['groupCode'] = $messageData['group_code'];
                    $message['sendUin'] = $messageData['send_uin'];
                } elseif ($messageData['poll_type'] == Message::TYPE_DISCUS) {
                    $message['discusId'] = $messageData['did'];
                    $message['sendUin'] = $messageData['send_uin'];
                }
                $messages[] = new Message($message);
            }
            return $messages;
        }
        throw new RuntimeException("Response Error");
    }
}
