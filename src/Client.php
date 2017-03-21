<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\Request;
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
            $status = $this->getVerifyQrCodeStatus();
            if ($status == VerifyQrCodeRequest::STATUS_EXPIRED) {
                $this->makeQrCodeImage($filePath);
            } elseif ($status == VerifyQrCodeRequest::STATUS_CERTIFICATION) {
                //授权成功跳出状态检查
                break;
            }
            sleep(1);
        }
        $ptwebqq = $this->getPtwebqq($this->parameters->get('certificationUrl'));
        $this->parameters->set('ptwebqq', $ptwebqq);
        $vfwebqq = $this->getVfwebqq($ptwebqq);
        $this->parameters->set('vfwebqq', $vfwebqq);
        list($uin, $psessionid) = $this->getUinAndPsessionid($ptwebqq);
        $this->parameters->set('uin', $uin);
        $this->parameters->set('psessionid', $psessionid);
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
            $certificationUrl = $this->extractUrlFromVerifyResponse(strval($response->getBody()));
            if ($certificationUrl ===  false) {
                throw new RuntimeException("Extract Certification Url Error");
            }
            $this->parameters->set('certificationUrl', $certificationUrl);
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