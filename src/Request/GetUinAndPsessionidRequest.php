<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Exception\RuntimeException;
use Slince\SmartQQ\UrlStore;

class GetUinAndPsessionidRequest extends Request
{
    protected $uri = UrlStore::GET_UINANDPSESSIONID;

    protected $referer = UrlStore::GET_UINANDPSESSIONID_REFERER;

    protected $method = RequestInterface::REQUEST_METHOD_POST;

    public function __construct(array $data)
    {
        $this->setParameter('r', \GuzzleHttp\json_encode($data));
    }

    /**
     * {@inheritdoc}
     */
    public static function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if (!isset($jsonData['result']['uin'])) {
            throw new RuntimeException("Can not find argument [uin] and [psessionid]");
        }
        return [$jsonData['result']['uin'], $jsonData['result']['psessionid']];
    }
}
