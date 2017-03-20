<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\Request;
use Slince\SmartQQ\Request\RequestInterface;

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

    }

    /**
     * @param RequestInterface $request
     * @return mixed|\Psr\Http\Message\ResponseInterface
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