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

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request as HttpRequest;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Slince\EventDispatcher\Dispatcher;
use Slince\EventDispatcher\DispatcherInterface;
use Slince\SmartQQ\Entity;
use Slince\SmartQQ\Exception\InvalidArgumentException;
use Slince\SmartQQ\Message\Request\FriendMessage;
use Slince\SmartQQ\Message\Request\GroupMessage;
use Slince\SmartQQ\Message\Request\Message as RequestMessage;
use Slince\SmartQQ\Message\Response\Message as ResponseMessage;
use Slince\SmartQQ\Request;

class Client
{
    /**
     * @var Credential
     */
    protected $credential;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var DispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var MessageHandler
     */
    protected $messageHandler;

    public function __construct(
        Credential $credential = null,
        HttpClient $httpClient = null,
        DispatcherInterface $eventDispatcher = null
    )
    {
        if (!is_null($credential)) {
            $this->setCredential($credential);
        }
        if (is_null($httpClient)) {
            $httpClient = new HttpClient([
                'verify' => false,
            ]);
        }
        if (is_null($eventDispatcher)) {
            $eventDispatcher = new Dispatcher();
        }
        $this->httpClient = $httpClient;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * 开启登录流程自行获取凭证
     *
     * @param string|callable $qrCallback 二维码图片位置|或者自定义处理器
     *
     * @return Credential
     */
    public function login($qrCallback)
    {
        $resolver = new CredentialResolver($this);

        // 兼容二维码位置传参
        if (is_string($qrCallback)) {
            $qrCallback = function ($qrcode) use($qrCallback){
                file_put_contents($qrCallback, $qrcode);
            };
        }

        // 进行授权流程，确认授权
        $credential = $resolver->resolve($qrCallback);
        $this->setCredential($credential);

        //获取在线状态避免103
        $this->getFriendsOnlineStatus();

        return $this->credential;
    }

    /**
     * 设置凭据.
     *
     * @param Credential $credential
     */
    public function setCredential(Credential $credential)
    {
        $this->credential = $credential;
    }

    /**
     * 获取正在使用的凭据.
     *
     * @return Credential
     */
    public function getCredential()
    {
        if (!$this->credential) {
            throw new InvalidArgumentException('Please login first or set a credential');
        }

        return $this->credential;
    }

    /**
     * 设置 http 请求客户端.
     *
     * @param HttpClient $httpClient
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * 获取 http 客户端
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * 设置事件处理器.
     *
     * @param DispatcherInterface $eventDispatcher
     */
    public function setEventDispatcher($eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * 获取事件处理器.
     *
     * @return DispatcherInterface
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * 获取所有的群.
     *
     * @return EntityCollection
     */
    public function getGroups()
    {
        $request = new Request\GetGroupsRequest($this->getCredential());
        $response = $this->sendRequest($request);

        return Request\GetGroupsRequest::parseResponse($response);
    }

    /**
     * 获取群详细信息.
     *
     * @param Entity\Group $group
     *
     * @return Entity\GroupDetail
     */
    public function getGroupDetail(Entity\Group $group)
    {
        $request = new Request\GetGroupDetailRequest($group, $this->getCredential());
        $response = $this->sendRequest($request);

        return Request\GetGroupDetailRequest::parseResponse($response);
    }

    /**
     * 获取所有讨论组.
     *
     * @return EntityCollection
     */
    public function getDiscusses()
    {
        $request = new Request\GetDiscussesRequest($this->getCredential());
        $response = $this->sendRequest($request);

        return Request\GetDiscussesRequest::parseResponse($response);
    }

    /**
     * 获取讨论组详情.
     *
     * @param Entity\Discuss $discuss
     *
     * @return Entity\DiscussDetail
     */
    public function getDiscussDetail(Entity\Discuss $discuss)
    {
        $request = new Request\GetDiscussDetailRequest($discuss, $this->getCredential());
        $response = $this->sendRequest($request);

        return Request\GetDiscussDetailRequest::parseResponse($response);
    }

    /**
     * 获取所有的好友.
     *
     * @return EntityCollection|Entity\Friend[]
     */
    public function getFriends()
    {
        $request = new Request\GetFriendsRequest($this->getCredential());
        $response = $this->sendRequest($request);

        return Request\GetFriendsRequest::parseResponse($response);
    }

    /**
     * 获取好友的详细信息.
     *
     * @param Entity\Friend $friend
     *
     * @return Entity\Profile
     */
    public function getFriendDetail(Entity\Friend $friend)
    {
        $request = new Request\GetFriendDetailRequest($friend, $this->getCredential());
        $response = $this->sendRequest($request);

        return Request\GetFriendDetailRequest::parseResponse($response);
    }

    /**
     * 获取好友的QQ号.
     *
     * @param Entity\Friend $friend
     *
     * @return int
     * @deprecated 此接口 Smartqq 官方已经不再提供
     */
    public function getFriendQQ(Entity\Friend $friend)
    {
        @trigger_error('The api is not supported now',E_USER_DEPRECATED);

        $request = new Request\GetQQRequest($friend, $this->getCredential());
        $response = $this->sendRequest($request);
        $qq = Request\GetQQRequest::parseResponse($response);
        $friend->setQq($qq);

        return $qq;
    }

    /**
     * 获取好友的个性签名.
     *
     * @param Entity\Friend $friend
     *
     * @return string
     */
    public function getFriendLnick(Entity\Friend $friend)
    {
        $request = new Request\GetLnickRequest($friend, $this->getCredential());
        $response = $this->sendRequest($request);

        return Request\GetLnickRequest::parseResponse($response, $friend);
    }

    /**
     * 获取好友在线状态
     *
     * @return EntityCollection
     */
    public function getFriendsOnlineStatus()
    {
        $request = new Request\GetFriendsOnlineStatusRequest($this->getCredential());
        $response = $this->sendRequest($request);

        return Request\GetFriendsOnlineStatusRequest::parseResponse($response);
    }

    /**
     * 获取最近的会话.
     *
     * @return EntityCollection|Entity\Recent[]
     */
    public function getRecentList()
    {
        $request = new Request\GetRecentListRequest($this->getCredential());
        $response = $this->sendRequest($request);

        return Request\GetRecentListRequest::parseResponse($response);
    }

    /**
     * 获取当前登录用户信息.
     *
     * @return Entity\Profile
     */
    public function getCurrentUserInfo()
    {
        $request = new Request\GetCurrentUserRequest();
        $response = $this->sendRequest($request);

        return Request\GetCurrentUserRequest::parseResponse($response);
    }

    /**
     * 轮询消息,
     * client并不会组装信息，只是将接口返回的信息完整抽象并返回
     * 如果需要查询信息对应的数据，如发送人、发送群，请自行获取.
     *
     * @return ResponseMessage[]
     */
    public function pollMessages()
    {
        $request = new Request\PollMessagesRequest($this->getCredential());
        $response = $this->sendRequest($request);

        return Request\PollMessagesRequest::parseResponse($response);
    }

    /**
     * 获取 Message handler.
     *
     * @return MessageHandler
     */
    public function getMessageHandler()
    {
        if (null !== $this->messageHandler) {
            return $this->messageHandler;
        }
        return $this->messageHandler = new MessageHandler($this);
    }

    /**
     * 发送消息，包括好友消息，群消息，讨论组消息.
     *
     * @param RequestMessage $message
     *
     * @return bool
     */
    public function sendMessage(RequestMessage $message)
    {
        if ($message instanceof FriendMessage) {
            $request = new Request\SendFriendMessageRequest($message, $this->getCredential());
        } elseif ($message instanceof GroupMessage) {
            $request = new Request\SendGroupMessageRequest($message, $this->getCredential());
        } else {
            $request = new Request\SendDiscusMessageRequest($message, $this->getCredential());
        }
        $response = $this->sendRequest($request);

        return Request\SendMessageRequest::parseResponse($response);
    }


    /**
     * 发送请求
     *
     * @param Request\RequestInterface $request
     * @param array $options
     *
     * @return HttpResponse
     */
    public function sendRequest(Request\RequestInterface $request, array $options = [])
    {
        // cookies 必须启用.
        if (!isset($options['cookies']) && $this->credential) {
            $options['cookies'] = $this->credential->getCookies();
        }
        if ($parameters = $request->getParameters()) {
            if (Request\RequestInterface::REQUEST_METHOD_GET == $request->getMethod()) {
                $options['query'] = $parameters;
            } else {
                $options['form_params'] = $parameters;
            }
        }
        //如果有referer需要伪造该信息
        if ($referer = $request->getReferer()) {
            $options['headers'] = [
                'Referer' => $referer,
            ];
        }
        $response = $this->httpClient->send(
            new HttpRequest($request->getMethod(), $request->getUri()),
            $options
        );

        return $response;
    }
}
