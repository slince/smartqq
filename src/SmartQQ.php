<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Slince\Cache\ArrayCache;
use Slince\SmartQQ\Exception\RuntimeException;
use Slince\SmartQQ\Request\GetPtWebQQRequest;
use Slince\SmartQQ\Request\GetQrCodeRequest;
use Slince\SmartQQ\Request\GetUinAndPsessionidRequest;
use Slince\SmartQQ\Request\GetVfWebQQRequest;
use Slince\SmartQQ\Request\RequestInterface;
use Slince\SmartQQ\Request\VerifyQrCodeRequest;
use Symfony\Component\Filesystem\Filesystem;

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
    function makeQrCodeImage($filePath)
    {
        $response = $this->request(new GetQrCodeRequest());
        $this->filesystem->dumpFile($filePath, $response->getBody());
    }

    /**
     * 获取QR Code认证结果
     * @return int
     */
    function getVerifyQrCodeStatus()
    {
        $request = new VerifyQrCodeRequest();
        $response = $this->request($request);
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
    function getPtWebQQ($certificationUrl)
    {
        $request = new GetPtWebQQRequest();
        $request->setUrl($certificationUrl);
        $response = $this->request($request);
        $response->getHeaderLine('set-cookie');
        $ptWebQQ = '';
        return $ptWebQQ;
    }

    /**
     * @param $ptWebQQ
     * @return string
     */
    function getVfWebQQ($ptWebQQ)
    {
        $request = new GetVfWebQQRequest();
        $request->setPtWebQQ($ptWebQQ);
        $response = $this->request($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return $jsonData['result']['vfwebqq'];
    }

    /**
     * 获取pessionid和uin
     * @param $ptWebQQ
     * @return array
     */
    function getUinAndPsessionid($ptWebQQ)
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
        $response = $this->request($request);
        $jsonData = \GuzzleHttp\json_decode($response);
        return [$jsonData['result']['uin'], $jsonData['result']['psessionid']];
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
    function request(RequestInterface $request)
    {
        $response = $this->httpClient->send($this->convertRequest($request));
        return $response;
    }

    protected function convertRequest(RequestInterface $request)
    {
        return new Request();
    }

    /**
     * @param array $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param string $name
     * @param mixed $parameter
     */
    public function setParameter($name, $parameter)
    {
        $this->parameters[$name] = $parameter;
    }

    /**
     * @return array
     */
    public function getParameter($name, $default = null)
    {
        return isset();
    }
}