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

use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Exception\RuntimeException;

class GetUinAndPsessionidRequest extends Request
{
    protected $uri = 'http://d1.web2.qq.com/channel/login2';

    protected $referer = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    protected $method = RequestInterface::REQUEST_METHOD_POST;

    public function __construct(array $data)
    {
        $this->setParameter('r', json_encode($data));
    }

    /**
     * {@inheritdoc}
     */
    public static function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if (!isset($jsonData['result']['uin'])) {
            throw new RuntimeException('Can not find argument [uin] and [psessionid]');
        }

        return [$jsonData['result']['uin'], $jsonData['result']['psessionid']];
    }
}
