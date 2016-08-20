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
use Slince\SmartQQ\Request\GetQQRequest;
use Slince\SmartQQ\Request\GetUserFriendsRequest;
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
     * @param $vfWebQQ
     * @param $uin
     * @param $ptWebQQ
     * @return mixed
     */
    function getUserFriends($vfWebQQ, $uin, $ptWebQQ)
    {
        $request = new GetUserFriendsRequest();
        $request->setParameters([
            'r' => json_encode([
                'vfwebqq' => $vfWebQQ,
                'hash' => $this->getHash($uin, $ptWebQQ),
            ])
        ]);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result']['friends'];
    }

    /**
     * 获取在线好友
     * @param $vfWebQQ
     * @param $psessionid
     * @return mixed
     */
    function getFriendsOnlineStatus($vfWebQQ, $psessionid)
    {
        $request = new GetFriendsOnlineStatusRequest();
        $request->setTokens([
            'vfwebqq' => $vfWebQQ,
            'psessionid' => $psessionid
        ]);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result'];
    }

    /**
     * 获取好友信息
     * @param $uin
     * @param $vfWebQQ
     * @return mixed
     */
    function getQQInfo($uin, $vfWebQQ)
    {
        $request = new GetQQRequest($uin);
        $request->setToken('vfwebqq', $vfWebQQ);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result'];
    }

    /**
     * 获取好友详情
     * @param $uin
     * @param $vfWebQQ
     * @param $psessionid
     * @return mixed
     */
    function getFriendDetail($uin, $vfWebQQ, $psessionid)
    {
        $request = new GetFriendDetailRequest($uin);
        $request->setTokens([
            'vfwebqq' => $vfWebQQ,
            'psessionid' => $psessionid
        ]);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result'];
    }

    /**
     * 获取群列表
     * @param $uin
     * @param $ptWebQQ
     * @param $vfWebQQ
     * @return mixed
     */
    function getGroups($uin, $ptWebQQ, $vfWebQQ)
    {
        $request = new GetGroupsRequest();
        $request->setParameters([
            'r' => json_encode([
                'vfwebqq' => $vfWebQQ,
                'hash' => $this->getHash($uin, $ptWebQQ),
            ])
        ]);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result'];
    }

    /**
     * 获取群信息
     * @param $groupCode
     * @param $vfWebQQ
     * @return mixed
     */
    function getGroupDetail($groupCode, $vfWebQQ)
    {
        $request = new GetGroupDetailRequest($groupCode);
        $request->setToken('vfwebqq', $vfWebQQ);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result'];
    }

    /**
     * 获取讨论组列表
     * @param $ptWebQQ
     * @param $vfWebQQ
     * @return mixed
     */
    function getDiscuses($psessionid, $vfWebQQ)
    {
        $request = new GetDiscusesRequest();
        $request->setTokens([
            'psessionid' => $psessionid,
            'vfwebqq' => $vfWebQQ
        ]);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result']['dnamelist'];
    }

    /**
     * 获取讨论组信息
     * @param $discussId
     * @param $vfWebQQ
     * @return mixed
     */
    function GetDiscusDetail($discussId, $vfWebQQ)
    {
        $request = new GetDiscusDetailRequest($discussId);
        $request->setToken('vfwebqq', $vfWebQQ);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result'];
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
        $response = $this->httpClient->send($this->convertRequest($request));
        return $response;
    }

    protected function convertRequest(RequestInterface $request)
    {
        return new Request();
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