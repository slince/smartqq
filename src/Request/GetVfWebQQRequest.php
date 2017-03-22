<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Exception\RuntimeException;
use Slince\SmartQQ\UrlStore;

class GetVfWebQQRequest extends Request
{
    protected $url = UrlStore::GET_VFWEBQQ;

    protected $referer = UrlStore::GET_VFWEBQQ_REFERER;

    public function __construct($ptWebQQ)
    {
        $this->setToken('ptwebqq', $ptWebQQ);
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public static function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if (!isset($jsonData['result']['vfwebqq'])) {
            throw new RuntimeException("Can not find argument [vfwebqq]");
        }
        return $jsonData['result']['vfwebqq'];
    }
}
