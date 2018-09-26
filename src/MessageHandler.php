<?php

/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ;


use GuzzleHttp\Exception\ConnectException;
use Slince\EventDispatcher\DispatcherInterface;
use Slince\EventDispatcher\Event;
use Slince\SmartQQ\Exception\InvalidArgumentException;
use Slince\SmartQQ\Exception\ResponseException;
use Slince\SmartQQ\Exception\RuntimeException;

class MessageHandler
{
    /**
     * 事件名，当收到消息时触发.
     *
     * @var string
     */
    const EVENT_MESSAGE = 'message';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var DispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * 可以被忽略的状态码.
     *
     * @var array
     */
    protected static $ignoredCodes = [
        0, 100003, 100100, 100012
    ];

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->eventDispatcher = $client->getEventDispatcher();
    }

    /**
     * 绑定消息处理回调
     *
     * ```php
     * $handler->onMessage(function(Slince\SmartQQ\Message\Response\Message $message){
     *      //...
     * });
     * ```
     *
     * @param callable $handler
     */
    public function onMessage($handler)
    {
        if (!is_callable($handler)) {
            throw new InvalidArgumentException('Message handler should be callable.');
        }
        $this->eventDispatcher->addListener(static::EVENT_MESSAGE, function(Event $event) use ($handler){
            $handler($event->getArgument('message'));
        });
    }

    /**
     * 开始监听客户端消息
     */
    public function listen()
    {
        while (true) {
            try {
                $messages =  $this->client->pollMessages();
                if ($messages) {
                    foreach ($messages as $message) {
                        // 收到消息时触发事件
                        $event = new Event(static::EVENT_MESSAGE, null, [
                            'message' => $message
                        ]);
                        $this->eventDispatcher->dispatch($event);
                    }
                } else {
                    //延缓2秒
                    usleep(2000000);
                }
            } catch (ResponseException $exception) {
                if (in_array($exception->getCode(), static::$ignoredCodes)) {
                    $this->testLogin();
                }
            } catch (ConnectException $exception) {
                usleep(2000000);
            }
        }
    }

    /**
     * 测试登录
     */
    protected function testLogin()
    {
        try {
            $this->client->getFriendsOnlineStatus();
        } catch (ResponseException $exc) {
            //登录凭证可能失效
            throw new RuntimeException('The credential may be expired, please login again.', $exc->getCode());
        }
    }
}