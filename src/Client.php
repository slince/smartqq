<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\Request;
use Slince\SmartQQ\Exception\RuntimeException;
use Slince\SmartQQ\Request\GetPtWebQQRequest;
use Slince\SmartQQ\Request\GetQrCodeRequest;
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
     * 保存登录二维码的位置
     * @var string
     */
    protected $loginQRImage;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * 获取ptwebqq的地址
     * @var string
     */
    protected $certificationUrl;

    public function __construct($loginQRImage = null)
    {
        $this->loginQRImage = $loginQRImage;
        $this->httpClient = new HttpClient([
            'cookies' => new CookieJar(),
            'verify' => false
        ]);
    }

    /**
     * 登录，创建凭证
     */
    public function login()
    {
        $this->makeQrCodeImage();
        while (true) {
            $status = $this->verifyQrCodeStatus();
            if ($status == VerifyQrCodeRequest::STATUS_EXPIRED) {
                $this->makeQrCodeImage();
            } elseif ($status == VerifyQrCodeRequest::STATUS_CERTIFICATION) {
                //授权成功跳出状态检查
                break;
            }
            sleep(1);
        }
        $ptwebqq = $this->getPtWebQQ($this->certificationUrl);
        $this->parameters->set('ptwebqq', $ptwebqq);
        $vfwebqq = $this->getVfwebqq($ptwebqq);
        $this->parameters->set('vfwebqq', $vfwebqq);
        list($uin, $psessionid) = $this->getUinAndPsessionid($ptwebqq);
        $this->parameters->set('uin', $uin);
        $this->parameters->set('psessionid', $psessionid);
    }


    /**
     * @param string $certificationUrl
     * @return string
     */
    protected function getPtWebQQ($certificationUrl)
    {
        $request = new GetPtWebQQRequest();
        $request->setUrl($certificationUrl);
        $this->send($request);
        foreach ($this->cookies as $cookie) {
            if (strcasecmp($cookie->getName(), 'ptwebqq') == 0) {
                return $cookie->getValue();
            }
        }
        throw new RuntimeException("Extract parameter [ptwebqq] error");
    }

    /**
     * @param $ptwebqq
     * @return string
     */
    protected function getVfwebqq($ptwebqq)
    {
        $request = new GetVfwebqqRequest();
        $request->setToken('ptwebqq', $ptwebqq);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        return $jsonData['result']['vfwebqq'];
    }

    /**
     * 获取pessionid和uin
     * @param $ptwebqq
     * @return array
     */
    protected function getUinAndPsessionid($ptwebqq)
    {
        $request = new GetUinAndPsessionidRequest();
        $request->setParameters([
            'r' => json_encode([
                'ptwebqq' => $ptwebqq,
                'clientid' => static::$clientId,
                'psessionid' => '',
                'status' => 'online'
            ])
        ]);
        $response = $this->send($request);
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        return [$jsonData['result']['uin'], $jsonData['result']['psessionid']];
    }


    /**
     * 创建登录所需的二维码
     * @return void
     */
    protected function makeQrCodeImage()
    {
        $response = $this->sendRequest(new GetQrCodeRequest());
        Utils::getFilesystem()->dumpFile($this->loginQRImage, $response->getBody());
    }

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
     * @param RequestInterface $request
     * @return mixed|ResponseInterface
     */
    public function sendRequest(RequestInterface $request)
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