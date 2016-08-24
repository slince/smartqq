<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;
use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Exception\RuntimeException;
use Slince\SmartQQ\Model\Member;

class GetQQRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_QQ;

    protected $referer = UrlStore::GET_QQ_REFERER;

    public function __construct($uin)
    {
        return str_replace('{uin}', $uin, $this->url);
    }

    /**
     * 解析响应数据
     * @param Response $response
     * @return Member
     */
    public function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0) {
            return new Member([
                'uin' => $jsonData['result']['uin'],
                'account' => $jsonData['result']['account']
            ]);
        }
        throw new RuntimeException("Response Error");
    }
}
