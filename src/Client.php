<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\Request;
use Slince\SmartQQ\Entity\Discuss;
use Slince\SmartQQ\Entity\Group;
use Slince\SmartQQ\Entity\GroupDetail;
use Slince\SmartQQ\Exception\RuntimeException;
use Slince\SmartQQ\Request\GetDiscusesRequest;
use Slince\SmartQQ\Request\GetDiscussDetailRequest;
use Slince\SmartQQ\Request\GetDiscussesRequest;
use Slince\SmartQQ\Request\GetGroupDetailRequest;
use Slince\SmartQQ\Request\GetGroupsRequest;
use Slince\SmartQQ\Request\GetPtWebQQRequest;
use Slince\SmartQQ\Request\GetQrCodeRequest;
use Slince\SmartQQ\Request\GetUinAndPsessionidRequest;
use Slince\SmartQQ\Request\GetVfWebQQRequest;
use Slince\SmartQQ\Request\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slince\SmartQQ\Request\VerifyQrCodeRequest;

class Client
{
    /**
     * @var Credential
     */
    protected $credential;

    /**
     * 客户端id(固定值)
     * @var int
     */
    protected static $clientId = 5399199;

    /**
     * 保存登录二维码的位置
     * @var string
     */
    protected $loginQRImage;

    /**
     * 获取ptwebqq的地址
     * @var string
     */
    protected $certificationUrl;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var CookieJar
     */
    protected $cookies;

    public function __construct(Credential $credential = null)
    {
        $this->cookies = new CookieJar();
        $this->httpClient = new HttpClient([
            'cookies' => $this->cookies,
            'verify' => false
        ]);
        $this->credential = $credential;
    }

    /**
     * 开启登录流程自行获取凭证
     * @param string $loginQRImage 二维码图片位置
     * @return Credential
     */
    public function login($loginQRImage)
    {
        $this->makeQrCodeImage($loginQRImage);
        while (true) {
            $status = $this->verifyQrCodeStatus();
            if ($status == VerifyQrCodeRequest::STATUS_EXPIRED) {
                $this->makeQrCodeImage($loginQRImage);
            } elseif ($status == VerifyQrCodeRequest::STATUS_CERTIFICATION) {
                //授权成功跳出状态检查
                break;
            }
            sleep(1);
        }
        $ptWebQQ = $this->getPtWebQQ($this->certificationUrl);
        $vfWebQQ = $this->getVfWebQQ($ptWebQQ);
        list($uin, $pSessionId) = $this->getUinAndPSessionId($ptWebQQ);
        $this->credential = new Credential($ptWebQQ, $vfWebQQ, $pSessionId, $uin, static::$clientId);
        return $this->credential;
    }


    /**
     * 创建登录所需的二维码
     * @param string $loginQRImage
     * @return void
     */
    protected function makeQrCodeImage($loginQRImage)
    {
        $response = $this->sendRequest(new GetQrCodeRequest());
        Utils::getFilesystem()->dumpFile($loginQRImage, $response->getBody());
    }

    /**
     * 验证二维码状态
     * @return int
     */
    protected function verifyQrCodeStatus()
    {
        $request = new VerifyQrCodeRequest();
        $response = $this->sendRequest($request);
        if (strpos($response->getBody(), '未失效') !== false) {
            $status = VerifyQrCodeRequest::STATUS_UNEXPIRED;
        } elseif (strpos($response->getBody(), '已失效') !== false) {
            $status = VerifyQrCodeRequest::STATUS_EXPIRED;
        } elseif (strpos($response->getBody(), '认证中') !== false) {
            $status = VerifyQrCodeRequest::STATUS_ACCREDITATION;
        } else {
            $status = VerifyQrCodeRequest::STATUS_CERTIFICATION;
            //找出认证url
            if (preg_match("#'(http*+)'#U", strval($response->getBody()), $matches)) {
                $this->certificationUrl = trim($matches[1]);
            } else {
                throw new RuntimeException("Can not find certification url");
            }
        }
        return $status;
    }

    /**
     * 获取ptwebqq的参数值
     * @param string $certificationUrl
     * @return string
     */
    protected function getPtWebQQ($certificationUrl)
    {
        $request = new GetPtWebQQRequest();
        $request->setUrl($certificationUrl);
        $this->sendRequest($request);
        foreach ($this->cookies as $cookie) {
            if (strcasecmp($cookie->getName(), 'ptwebqq') == 0) {
                return $cookie->getValue();
            }
        }
        throw new RuntimeException("Extract parameter [ptwebqq] error");
    }

    /**
     * @param string $ptWebQQ
     * @return string
     */
    protected function getVfWebQQ($ptWebQQ)
    {
        $request = new GetVfWebQQRequest($ptWebQQ);
        $response = $this->sendRequest($request);
        return GetVfWebQQRequest::parseResponse($response);
    }

    /**
     * 获取pessionid和uin
     * @param string $ptWebQQ
     * @return array
     */
    protected function getUinAndPSessionId($ptWebQQ)
    {
        $request = new GetUinAndPsessionidRequest([
            'ptwebqq' => $ptWebQQ,
            'clientid' => static::$clientId,
            'psessionid' => '',
            'status' => 'online'
        ]);
        $response = $this->sendRequest($request);
        return GetUinAndPsessionidRequest::parseResponse($response);
    }

    /**
     * 获取所有的群
     * @return EntityCollection
     */
    public function getGroups()
    {
        $request = new GetGroupsRequest($this->credential);
        $response = $this->sendRequest($request);
        return GetGroupsRequest::parseResponse($response, $this);
    }

    /**
     * 获取群详细信息
     * @param Group $group
     * @return GroupDetail
     */
    public function getGroupDetail(Group $group)
    {
        $request = new GetGroupDetailRequest($group, $this->credential);
        $response = $this->sendRequest($request);
        return GetGroupDetailRequest::parseResponse($response);
    }

    /**
     * 获取所有讨论组
     * @return EntityCollection
     */
    public function getDiscusses()
    {
        $request = new GetDiscussesRequest($this->credential);
        $response = $this->sendRequest($request);
        return GetDiscussesRequest::parseResponse($response);
    }

    public function getDiscussDetail(Discuss $discuss)
    {
        $request = new GetDiscussDetailRequest($discuss, $this->credential);
        $response = $this->sendRequest($request);
        return GetDiscussDetailRequest::parseResponse($response);
    }

    /**
     * @param RequestInterface $request
     * @return mixed|ResponseInterface
     */
    protected function sendRequest(RequestInterface $request)
    {
        $options = [];
        if ($parameters = $request->getParameters()) {
            if ($request->getMethod() == RequestInterface::REQUEST_METHOD_GET) {
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
        $response = $this->httpClient->send(new Request($request->getMethod(), $request->getUri()), $options);
        return $response;
    }
}