<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Slince\SmartQQ\Request\GetDiscusDetailRequest;
use Slince\SmartQQ\Request\GetDiscusesRequest;
use Slince\SmartQQ\Request\GetFriendDetailRequest;
use Slince\SmartQQ\Request\GetFriendsOnlineStatusRequest;
use Slince\SmartQQ\Request\GetGroupDetailRequest;
use Slince\SmartQQ\Request\GetGroupsRequest;
use Slince\SmartQQ\Request\GetLoginInfoRequest;
use Slince\SmartQQ\Request\GetQQRequest;
use Slince\SmartQQ\Request\GetRecentListRequest;
use Slince\SmartQQ\Request\GetUserFriendsRequest;
use Slince\SmartQQ\Request\PollMessagesRequest;
use Slince\SmartQQ\Request\SendDiscusMessageRequest;
use Slince\SmartQQ\Request\SendFriendMessageRequest;
use Slince\SmartQQ\Request\SendGroupMessageRequest;
use Symfony\Component\Filesystem\Filesystem;
use Slince\Cache\ArrayCache;
use Slince\SmartQQ\Exception\RuntimeException;
use Slince\SmartQQ\Request\GetPtWebQQRequest;
use Slince\SmartQQ\Request\GetQrCodeRequest;
use Slince\SmartQQ\Request\GetUinAndPsessionidRequest;
use Slince\SmartQQ\Request\GetVfWebQQRequest;
use Slince\SmartQQ\Request\RequestInterface;
use Slince\SmartQQ\Request\VerifyQrCodeRequest;


class SmartQQ
{

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * 参数存储
     * @var ArrayCache
     */
    protected $parameters;

    function __construct()
    {
        $this->filesystem = new Filesystem();
        $this->httpClient = new Client();
        $this->parameters = new ArrayCache();
    }

    /**
     * 登录
     * @param string $filePath 二维码图片位置
     */
    function login($filePath)
    {
        $this->makeQrCodeImage($filePath);
        while (true) {
            $status = $this->getVerifyQrCodeStatus();
            if ($status == VerifyQrCodeRequest::STATUS_EXPIRED) {
                $this->makeQrCodeImage($filePath);
            } elseif ($status == VerifyQrCodeRequest::STATUS_CERTIFICATION) {
                //授权成功跳出状态检查
                break;
            }
            sleep(1);
        }
        $ptWebQQ = $this->getPtWebQQ($this->parameters->get('certificationUrl'));
        $this->parameters->set('ptWebQQ', $ptWebQQ);
        $vfWebQQ = $this->getVfWebQQ($ptWebQQ);
        $this->parameters->set('vfWebQQ', $vfWebQQ);
        list($uin, $psessionId) = $this->getUinAndPsessionid($ptWebQQ);
        $this->parameters->set('uin', $uin);
        $this->parameters->set('psessionId', $psessionId);
    }

    /**
     * @param $filePath
     */
    protected function makeQrCodeImage($filePath)
    {
        $response = $this->send(new GetQrCodeRequest());
        $this->filesystem->dumpFile($filePath, $response->getBody());
    }

    /**
     * 获取QR Code认证结果
     * @return int
     */
    protected function getVerifyQrCodeStatus()
    {
        $request = new VerifyQrCodeRequest();
        $response = $this->send($request);
        if (strpos($response->getBody(), '未失效') !== false) {
            $status = VerifyQrCodeRequest::STATUS_UNEXPIRED;
        } elseif (strpos($response->getBody(), '已失效') !== false) {
            $status = VerifyQrCodeRequest::STATUS_EXPIRED;
        } elseif (strpos($response->getBody(), '认证中') !== false) {
            $status = VerifyQrCodeRequest::STATUS_ACCREDITATION;
        } else {
            file_put_contents(getcwd() . '/a.log', strval($response->getBody()));
            var_dump(strval($response->getBody()));exit;
            $status = VerifyQrCodeRequest::STATUS_CERTIFICATION;
            $certificationUrl = $this->extractUrlFromVerifyResponse(strval($response->getBody()));
            if ($certificationUrl ===  false) {
                throw new RuntimeException("Extract Certification Url Error");
            }
            $this->parameters->set('certificationUrl', $certificationUrl);
        }
        return $status;
    }

    /**
     * @param $certificationUrl
     * @return string
     */
    protected function getPtWebQQ($certificationUrl)
    {
        $request = new GetPtWebQQRequest();
        $request->setUrl($certificationUrl);
        $response = $this->send($request);
        $response->getHeaderLine('set-cookie');
        $ptWebQQ = '';
        return $ptWebQQ;
    }

    /**
     * @param $ptWebQQ
     * @return string
     */
    protected function getVfWebQQ($ptWebQQ)
    {
        $request = new GetVfWebQQRequest();
        $request->setToken('ptwebqq', $ptWebQQ);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result']['vfwebqq'];
    }

    /**
     * 获取pessionid和uin
     * @param $ptWebQQ
     * @return array
     */
    protected function getUinAndPsessionid($ptWebQQ)
    {
        $request = new GetUinAndPsessionidRequest();
        $request->setParameters([
            'r' => json_encode([
                'ptwebqq' => $ptWebQQ,
                'clientid' => 53999199,
                'psessionid' => '',
                'status' => 'online'
            ])
        ]);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return [$jsonData['result']['uin'], $jsonData['result']['psessionid']];
    }

    /**
     * 获取好友
     * @return array
     */
    function getUserFriends()
    {
        $request = new GetUserFriendsRequest();
        $request->setParameters([
            'r' => json_encode([
                'vfwebqq' => $this->parameters->get('vfWebQQ'),
                'hash' => $this->getHash($this->parameters->get('uin'), $this->parameters->get('ptWebQQ')),
            ])
        ]);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result']['friends'];
    }

    /**
     * 获取在线好友
     * @return array
     */
    function getFriendsOnlineStatus()
    {
        $request = new GetFriendsOnlineStatusRequest();
        $request->setTokens([
            'vfwebqq' => $this->parameters->get('vfWebQQ'),
            'psessionid' => $this->parameters->get('psessionid')
        ]);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result'];
    }

    /**
     * 获取好友信息
     * @param $uin
     * @return mixed
     */
    function getQQInfo($uin)
    {
        $request = new GetQQRequest($uin);
        $request->setToken('vfwebqq', $this->parameters->get('vfWebQQ'));
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result'];
    }

    /**
     * 获取好友详情
     * @param $uin
     * @return mixed
     */
    function getFriendDetail($uin)
    {
        $request = new GetFriendDetailRequest($uin);
        $request->setTokens([
            'vfwebqq' => $this->parameters->get('vfWebQQ'),
            'psessionid' => $this->parameters->get('psessionid')
        ]);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result'];
    }

    /**
     * 获取群列表
     * @return mixed
     */
    function getGroups()
    {
        $request = new GetGroupsRequest();
        $request->setParameter('r', json_encode([
            'vfwebqq' => $this->parameters->get('vfWebQQ'),
            'hash' => $this->getHash($this->parameters->get('uin'), $this->parameters->get('ptWebQQ')),
        ]));
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result'];
    }

    /**
     * 获取群信息
     * @param $groupCode
     * @return array
     */
    function getGroupDetail($groupCode)
    {
        $request = new GetGroupDetailRequest($groupCode);
        $request->setToken('vfwebqq', $this->parameters->get('vfWebQQ'));
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result'];
    }

    /**
     * 获取讨论组列表
     * @return array
     */
    function getDiscuses()
    {
        $request = new GetDiscusesRequest();
        $request->setTokens([
            'psessionid' => $this->parameters->get('psessionid'),
            'vfwebqq' => $this->parameters->get('vfWebQQ')
        ]);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result']['dnamelist'];
    }

    /**
     * 获取讨论组信息
     * @param $discussId
     * @return array
     */
    function getDiscusDetail($discussId)
    {
        $request = new GetDiscusDetailRequest($discussId);
        $request->setToken('vfwebqq', $this->parameters->get('vfWebQQ'));
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result'];
    }

    /**
     * 获取最近会话
     * @return array
     */
    function getRecentList()
    {
        $request = new GetRecentListRequest();
        $request->setParameter('r', json_encode([
            'vfwebqq' => $this->parameters->get('vfWebQQ'),
            'clientid' => 53999199,
            'psessionid' => $this->parameters->get('psessionid')
        ]));
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result'];
    }

    /**
     * 获取最近会话
     * @return array
     */
    function getLoginInfo()
    {
        $request = new GetLoginInfoRequest();
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result'];
    }

    /**
     * 轮询消息
     * @return array
     */
    function pollMessages()
    {
        $request = new PollMessagesRequest();
        $response = $this->send($request);
        return \GuzzleHttp\json_decode($response);
    }

    /**
     * 发送消息给好友
     * @param $userId
     * @param $message
     * @return bool
     */
    function sendMessageToFriend($userId, $message)
    {
        $request = new SendFriendMessageRequest();
        $request->setParameter('r', json_encode([
            'to' => $userId,
            'content' => [
                $message,
                [
                    'font' => [
                        'name' => '宋体',
                        'size'=> 10,
                        'style'=> [0, 0, 0],
                        'color' => '000000'
                    ]
                ],
                'face' => 522,
                'clientid' => '53999199',
                'msg_id' => '65890001',
                'psessionid' => $this->parameters->get('psessionid')
            ]
        ]));
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['errCode'] === 0;
    }

    /**
     * 发送消息到群
     * @param $groupUin
     * @param $message
     * @return bool
     */
    function sendMessageToGroup($groupUin, $message)
    {
        $request = new SendGroupMessageRequest();
        $request->setParameter('r', json_encode([
            'group_uin' => $groupUin,
            'content' => [
                $message,
                [
                    'font' => [
                        'name' => '宋体',
                        'size'=> 10,
                        'style'=> [0, 0, 0],
                        'color' => '000000'
                    ]
                ],
                'face' => 522,
                'clientid' => '53999199',
                'msg_id' => '65890001',
                'psessionid' => $this->parameters->get('psessionid')
            ]
        ]));
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['errCode'] === 0;
    }

    /**
     * 发送消息到讨论组
     * @param $discussId
     * @param $message
     * @return bool
     */
    function sendMessageToDiscus($discussId, $message)
    {
        $request = new SendDiscusMessageRequest();
        $request->setParameter('r', json_encode([
            'did' => $discussId,
            'content' => [
                $message,
                [
                    'font' => [
                        'name' => '宋体',
                        'size'=> 10,
                        'style'=> [0, 0, 0],
                        'color' => '000000'
                    ]
                ],
                'face' => 522,
                'clientid' => '53999199',
                'msg_id' => '65890001',
                'psessionid' => $this->parameters->get('psessionid')
            ]
        ]));
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['errCode'] === 0;
    }

    /**
     * 从验证结果中提取下一步登录所需要的参数
     * @param $response
     * @return bool
     */
    protected function extractUrlFromVerifyResponse($response)
    {
        foreach (explode(',', $response) as $fragment) {
            if (strpos($fragment, 'http') !== false) {
                return $fragment;
            }
        }
        return false;
    }

    /**
     * 发送请求
     * @param RequestInterface $request
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function send(RequestInterface $request)
    {
        $options = [
            'verify' => false
        ];
        if ($parameters = $request->getParameters()) {
            if ($request->getRequestMethod() == RequestInterface::REQUEST_METHOD_GET) {
                $options['query'] = $parameters;
            } else {
                $options['form_params'] = $parameters;
            }
        }
        //如果有referer需要伪造该信息
        if ($referer = $request->getReferer()) {
            $options['headers'] = [
                'Referer' => $referer
            ];
        }
        $response = $this->httpClient->send($this->convertRequest($request), $options);
        return $response;
    }

    /**
     * 转换请求成PSR请求
     * @param RequestInterface $request
     * @return Request
     */
    protected function convertRequest(RequestInterface $request)
    {
        $psrRequest = new Request($request->getRequestMethod(),
            $request->getUrl()
        );
        return $psrRequest;
    }

    /**
     * 获取uin和ptWebQQ参数hash之后的结果
     * @param $uin
     * @param $ptWebQQ
     * @return string
     */
    protected function getHash($uin, $ptWebQQ)
    {
        static $hash = '';
        if (empty($hash)) {
            $hash = static::hash($uin, $ptWebQQ);
        }
        return $hash;
    }

    /**
     * hash
     * @param $uin
     * @param $ptWebQQ
     * @return string
     */
    protected static function hash($uin, $ptWebQQ) {
        $x = array(
            0, $uin >> 24 & 0xff ^ 0x45,
            0, $uin >> 16 & 0xff ^ 0x43,
            0, $uin >>  8 & 0xff ^ 0x4f,
            0, $uin       & 0xff ^ 0x4b,
        );
        for ($i = 0; $i < 64; ++$i)
            $x[($i & 3) << 1] ^= ord(substr($ptWebQQ, $i, 1));
        $hex = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
        $hash = '';
        for ($i = 0; $i < 8; ++$i)
            $hash .= $hex[$x[$i] >> 4 & 0xf] . $hex[$x[$i] & 0xf];
        return $hash;
    }
}