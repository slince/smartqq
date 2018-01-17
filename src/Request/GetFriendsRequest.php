<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ\Request;

use Cake\Collection\Collection;
use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Entity\Category;
use Slince\SmartQQ\Entity\Friend;
use Slince\SmartQQ\EntityCollection;
use Slince\SmartQQ\EntityFactory;
use Slince\SmartQQ\Exception\ResponseException;
use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Utils;

class GetFriendsRequest extends Request
{
    protected $uri = 'http://s.web2.qq.com/api/get_user_friends2';

    protected $referer = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    protected $method = RequestInterface::REQUEST_METHOD_POST;

    public function __construct(Credential $credential)
    {
        $this->setParameter('r', \GuzzleHttp\json_encode([
            'vfwebqq' => $credential->getVfWebQQ(),
            'hash' => Utils::hash($credential->getUin(), $credential->getPtWebQQ()),
        ]));
    }

    /**
     * 解析响应数据.
     *
     * @param Response $response
     *
     * @return EntityCollection
     */
    public static function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        //有时候获取好友接口retcode=100003时也可以获取数据，但数据不完整故当做无效返回
        if ($jsonData && 0 == $jsonData['retcode']) {
            //好友基本信息
            $friendDatas = (new Collection($jsonData['result']['friends']))->combine('uin', function($entity) {
                return $entity;
            })->toArray();
            //markNames
            $markNames = (new Collection($jsonData['result']['marknames']))->combine('uin', function($entity) {
                return $entity;
            })->toArray();
            //分类
            $categories = (new Collection($jsonData['result']['categories']))->combine('index', function($entity) {
                return $entity;
            })->toArray();
            //vip信息
            $vipInfos = (new Collection($jsonData['result']['vipinfo']))->combine('u', function($entity) {
                return $entity;
            })->toArray();
            $friends = [];
            foreach ($jsonData['result']['info'] as $friendData) {
                $uin = $friendData['uin'];
                $friend = [
                    'uin' => $friendData['uin'],
                    'flag' => $friendData['flag'],
                    'face' => $friendData['face'],
                    'nick' => $friendData['nick'],
                    'markName' => isset($markNames[$uin]) ? $markNames[$uin]['markname'] : null,
                    'isVip' => isset($vipInfos[$uin]) ? $vipInfos[$uin]['is_vip'] == 1 : false,
                    'vipLevel' => isset($vipInfos[$uin]) ? $vipInfos[$uin]['vip_level'] : 0,
                ];
                $category = null;
                if (isset($friendDatas[$uin])) {
                    $categoryIndex = $friendDatas[$uin]['categories'];
                    if (0 == $categoryIndex) {
                        $category = Category::createMyFriendCategory();
                    } else {
                        $category = new Category($categories[$categoryIndex]['name'],
                            $categories[$categoryIndex]['index'],
                            $categories[$categoryIndex]['sort']
                        );
                    }
                }
                $friend['category'] = $category;
                $friends[] = EntityFactory::createEntity(Friend::class, $friend);
            }

            return new EntityCollection($friends);
        }
        throw new ResponseException($jsonData['retcode'], $response);
    }
}
