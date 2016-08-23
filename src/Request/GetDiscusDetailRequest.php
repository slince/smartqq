<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

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
     * @return Group
     */
    function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0) {
            $groupData = $jsonData['result']['ginfo'];
            $vips = Hash::combine($jsonData['result']['vipinfo'], "{n}.u", "{n}");
            $members = [];
            foreach ($jsonData['result']['minfo'] as $memberData) {
                $member = new Member([
                    'uin' => $memberData['uin'],
                    'nickname' => $memberData['nick'],
                    'profile' => new Profile($memberData),
                    'isVip' => isset($vips[$memberData['uin']]) ?  $vips[$memberData['uin']]['is_vip'] : 0,
                    'vipLevel' => isset($vips[$memberData['uin']]) ?  $vips[$memberData['uin']]['vip_level'] : 0,
                ]);
                $members[] = new Member($member);
            }
            $groupData['members'] = $members;
            return new Group($groupData);
        }
        throw new RuntimeException("Response Error");
    }
}
