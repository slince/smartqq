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

use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Exception\Code103ResponseException;
use Slince\SmartQQ\Exception\ResponseException;
use Slince\SmartQQ\Exception\RuntimeException;
use Slince\SmartQQ\Message\Content;
use Slince\SmartQQ\Message\Font;
use Slince\SmartQQ\Message\Response\DiscussMessage;
use Slince\SmartQQ\Message\Response\FriendMessage;
use Slince\SmartQQ\Message\Response\GroupMessage;
use Slince\SmartQQ\Message\Response\Message;

class PollMessagesRequest extends Request
{
    protected $uri = 'http://d1.web2.qq.com/channel/poll2';

    protected $referer = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    protected $method = RequestInterface::REQUEST_METHOD_POST;

    public function __construct(Credential $credential)
    {
        $this->setParameter('r', \GuzzleHttp\json_encode([
            'ptwebqq' => '',
            'clientid' => $credential->getClientId(),
            'psessionid' => $credential->getPSessionId(),
            'key' => '',
        ]));
    }

    /**
     * 解析响应数据.
     *
     * @param Response $response
     *
     * @return Message[]
     */
    public static function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && 0 == $jsonData['retcode'] && !empty($jsonData['result'])) {
            $messages = [];
            foreach ($jsonData['result'] as $messageData) {
                $messages[] = static::makeResponseMessage($messageData['poll_type'], $messageData);
            }

            return $messages;
        } elseif (103 == $jsonData['retcode']) {
            throw new Code103ResponseException($response);
        }
        throw new ResponseException($jsonData['retcode'], $response);
    }

    protected static function makeResponseMessage($type, $messageData)
    {
        $contents = $messageData['value']['content'];
        //消息正文
        $content = static::parseContents($contents);
        switch ($messageData['poll_type']) {
            case Message::TYPE_FRIEND:
                $message = new FriendMessage(
                    $messageData['value']['to_uin'],
                    $messageData['value']['from_uin'],
                    $content,
                    $messageData['value']['time'],
                    $messageData['value']['msg_id'],
                    $messageData['value']['msg_type']
                );
                break;
            case Message::TYPE_GROUP:
                $message = new GroupMessage(
                    $messageData['value']['to_uin'],
                    $messageData['value']['from_uin'],
                    $messageData['value']['group_code'],
                    $messageData['value']['send_uin'],
                    $content,
                    $messageData['value']['time'],
                    $messageData['value']['msg_id'],
                    $messageData['value']['msg_type']
                );
                break;
            case Message::TYPE_DISCUSS:
                $message = new DiscussMessage(
                    $messageData['value']['to_uin'],
                    $messageData['value']['from_uin'],
                    $messageData['value']['did'],
                    $messageData['value']['send_uin'],
                    $content,
                    $messageData['value']['time'],
                    $messageData['value']['msg_id'],
                    $messageData['value']['msg_type']
                );
                break;
            default:
                throw new RuntimeException(sprintf('Unknown message type [%s]', $type));
                break;
        }

        return $message;
    }

    /**
     * Parse Contents.
     *
     * @param array $contents
     *
     * @return Content
     */
    protected static function parseContents($contents)
    {
        //正文字体
        $fontParameters = $contents[0][1];
        $font = new Font($fontParameters['name'],
            $fontParameters['color'],
            $fontParameters['size'],
            $fontParameters['style']
        );
        unset($contents[0]);
        $contentString = implode('', array_map(function($content){
            if ($content && is_array($content) && 'face' === $content[0]) { //处理表情
                $faceText = Content::searchFaceText($content[1]);

                return $faceText ? '['.$faceText.']' : '';
            } else {
                return (string) $content;
            }
        }, $contents));

        return new Content($contentString, $font);
    }
}
