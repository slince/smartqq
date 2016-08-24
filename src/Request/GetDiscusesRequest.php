<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Cake\Utility\Hash;
use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Exception\RuntimeException;
use Slince\SmartQQ\Model\Discus;
use Slince\SmartQQ\Model\Group;
use Slince\SmartQQ\UrlStore;

class GetDiscusesRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_DISCUSES;

    protected $referer = UrlStore::GET_DISCUSES_REFERER;

    /**
     * 解析响应数据
     * @param Response $response
     * @return Discus[]
     */
    public function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0) {
            $discuses = [];
            foreach ($jsonData['result']['dnamelist'] as $discusData) {
                $discuses[] = new Discus([
                    'id' => $discusData['did'],
                    'name' => $discusData['name']
                ]);
            }
            return $discuses;
        }
        throw new RuntimeException("Response Error");
    }
}
