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

class GetVfWebQQRequest extends Request
{
    protected $uri = 'http://s.web2.qq.com/api/getvfwebqq?ptwebqq={ptwebqq}&clientid=53999199&psessionid=&t=0.1';

    protected $referer = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    public function __construct($ptWebQQ)
    {
        $this->setToken('ptwebqq', $ptWebQQ);
    }

    /**
     * {@inheritdoc}
     */
    public static function parseResponse(Response $response)
    {
        $jsonData = \GuzzleHttp\json_decode($response->getBody(), true);
        if (!isset($jsonData['result']['vfwebqq'])) {
            throw new RuntimeException('Can not find argument [vfwebqq]');
        }

        return $jsonData['result']['vfwebqq'];
    }
}
