<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Entity\Discuss;
use Slince\SmartQQ\EntityCollection;
use Slince\SmartQQ\EntityFactory;
use Slince\SmartQQ\Exception\ResponseException;

class GetDiscussesRequest extends Request
{
    protected $uri = 'http://s.web2.qq.com/api/get_discus_list?clientid=53999199&psessionid={psessionid}&vfwebqq={vfwebqq}&t=0.1';

    protected $referer = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    public function __construct(Credential $credential)
    {
        $this->setTokens([
            'psessionid' => $credential->getPSessionId(),
            'vfwebqq' => $credential->getVfWebQQ()
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
            $discusses = [];
            foreach ($jsonData['result']['dnamelist'] as $discussData) {
                $discusses[] = EntityFactory::createEntity(Discuss::class, [
                     'id' => $discussData['did'],
                     'name' => $discussData['name'],
                ]);
            }
            return new EntityCollection($discusses);
        }
        throw new ResponseException($jsonData['retcode'], $response);
    }
}
