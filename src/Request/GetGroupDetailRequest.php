<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Cake\Utility\Hash;
use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Exception\ResponseException;
use Slince\SmartQQ\Model\Group;
use Slince\SmartQQ\Model\Member;
use Slince\SmartQQ\Model\Profile;
use Slince\SmartQQ\UrlStore;

class GetGroupDetailRequest extends AbstractRequest
{
    protected $url = UrlStore::GET_GROUP_DETAIL;

    protected $referer = UrlStore::GET_GROUP_DETAIL_REFERER;

    public function __construct($groupCode)
    {
        $this->url = str_replace('{group_code}', $groupCode, $this->url);
    }

    /**
     * 解析响应数据
     * @param Response $response
     * @return Group
     */
    public function parseResponse(Response $response)
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
                $members[] = $member;
            }
            $groupData['members'] = $members;
            $groupData['id'] = $groupData['gid'];
            unset($groupData['gid']);
            return new Group($groupData);
        }
        throw new ResponseException("Response Error");
    }
}
