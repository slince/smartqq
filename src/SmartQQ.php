<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Slince\SmartQQ\Request\GetQrCodeRequest;
use Slince\SmartQQ\Request\RequestInterface;
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

    function __construct()
    {
        $this->filesystem = new Filesystem();
        $this->httpClient = new Client();
    }

    /**
     * @param $filePath
     */
    function makeQrCodeImage($filePath)
    {
        $response = $this->request(new GetQrCodeRequest());
        $this->filesystem->dumpFile($filePath, $response->getBody());
    }

    function waitingVerifyCode()
    {
        while (true) {
            $response =
        }
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
}