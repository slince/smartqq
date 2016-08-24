<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Cake\Utility\Hash;
use Slince\SmartQQ\Exception\RuntimeException;
use Slince\SmartQQ\Model\Category;
use Slince\SmartQQ\Model\Member;
use Slince\SmartQQ\UrlStore;
use GuzzleHttp\Psr7\Response;

class GetUserFriendsRequest extends AbstractRequest
{

    protected $url = UrlStore::GET_USER_FRIENDS;

    protected $referer = UrlStore::GET_USER_FRIENDS_REFERER;

    protected $requestMethod = RequestInterface::REQUEST_METHOD_POST;

    /**
     * 解析响应数据
     * @param Response $response
     * @return Member[]
     */
    public function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0) {
            $friends = Hash::combine($jsonData['result']['friends'], "{n}.uin", "{n}");
            $marknames = Hash::combine($jsonData['result']['marknames'], "{n}.uin", "{n}");
            $vips = Hash::combine($jsonData['result']['vipinfo'], "{n}.u", "{n}");
            $infos = Hash::combine($jsonData['result']['info'], "{n}.uin", "{n}");
            $categories = Hash::combine($jsonData['result']['categories'], "{n}.index", "{n}");
            $members = [];
            foreach ($friends as $uin => $friend) {
                $memberData = [
                    'uin' => $friend['uin'],
                    'nickname' => $infos[$uin]['nick'],
                    'status' => '',
                    'clientType' => 0,
                    'account' => '',
                    'markname' => isset($marknames[$uin]) ?  $marknames[$uin]['markname'] : '',
                    'isVip' => isset($vips[$uin]) ?  $vips[$uin]['is_vip'] : 0,
                    'vipLevel' => isset($vips[$uin]) ?  $vips[$uin]['vip_level'] : 0,
                    'category' => isset($categories[$friend['categories']])
                        ? new Category($categories[$friend['categories']]) : null,
                    'profile' => null
                ];
                $members[] = new Member($memberData);
            }
            return $members;
        }
        throw new RuntimeException("Response Error");
    }
}
