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
use Slince\SmartQQ\Model\Member;
use Slince\SmartQQ\UrlStore;

class GetDiscusDetailRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_DISCUS_DETAIL;

    protected $referer = UrlStore::GET_DISCUS_DETAIL_REFERER;

    public function __construct($discussId)
    {
        $this->url = str_replace('{discuss_id}', $discussId, $this->url);
    }

    /**
     * 解析响应数据
     * @param Response $response
     * @return Discus
     */
    public function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0) {
            $discusData = [
                'id' => $jsonData['result']['info']['did'],
                'name' => $jsonData['result']['info']['discu_name'],
            ];
            $stauses = Hash::combine($jsonData['result']['mem_status'], "{n}.uin", "{n}");
            $members = [];
            foreach ($jsonData['result']['mem_info'] as $memberData) {
                $members[] = new Member([
                    'uin' => $memberData['uin'],
                    'nickname' => $memberData['nick'],
                    'clientType' => isset($stauses[$memberData['uin']]) ? $stauses[$memberData['uin']] : 0,
                    'status' => isset($stauses[$memberData['uin']]) ? $stauses[$memberData['uin']] : 0,
                ]);
            }
            $discusData['members'] = $members;
            return new Discus($discusData);
        }
        throw new RuntimeException("Response Error");
    }
}
