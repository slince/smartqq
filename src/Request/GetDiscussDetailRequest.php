<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Cake\Collection\Collection;
use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Entity\Discuss;
use Slince\SmartQQ\Entity\DiscussDetail;
use Slince\SmartQQ\Entity\DiscussMember;
use Slince\SmartQQ\EntityCollection;
use Slince\SmartQQ\EntityFactory;
use Slince\SmartQQ\Exception\ResponseException;

class GetDiscussDetailRequest extends Request
{
    protected $url = 'http://d1.web2.qq.com/channel/get_discu_info?did={discussId}&psessionid={psessionid}&vfwebqq={vfwebqq}&clientid=53999199&t=0.1';

    protected $referer = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    public function __construct(Discuss $discuss, Credential $credential)
    {
        $this->setTokens([
            'discussId' => $discuss->getId(),
            'psessionid' => $credential->getPSessionId(),
            'vfwebqq' => $credential->getVfWebQQ(),
        ]);
    }

    /**
     * 解析响应数据
     * @param Response $response
     * @return EntityCollection
     */
    public static function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if ($jsonData && $jsonData['retcode'] == 0) {
            //成员在线状态
            $statuses = (new Collection($jsonData['result']['mem_status']))->combine('uin', function($entity){
                return $entity;
            });
            //成员基本信息
            $ruins = (new Collection($jsonData['result']['info']['mem_list']))->combine('mem_uin', 'ruin');
            //讨论组基本详情
            $discussData = $jsonData['result']['info'];
            $discussDetailData = [
                'id' => $discussData['did'],
                'name' => $discussData['discu_name'],
            ];
            $members = [];
            foreach ($jsonData['result']['mem_info'] as $memberData) {
                $uin = $memberData['uin'];
                $members[] = EntityFactory::createEntity(DiscussMember::class, [
                   'uin' => $uin,
                   'nick' => $memberData['nick'],
                   'clientType' => isset($statuses[$uin]) ? $statuses[$uin]['client_type'] : null,
                   'status' => isset($statuses[$uin]) ? $statuses[$uin]['status'] : null,
                ]);
            }
            $discussDetailData['members'] = new EntityCollection($members);
            return EntityFactory::createEntity(DiscussDetail::class, $discussDetailData);
        }
        throw new ResponseException("Response Error");
    }
}
