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
use Slince\SmartQQ\Entity\Profile;

class GetCurrentUserRequest extends Request
{
    protected $uri = 'http://s.web2.qq.com/api/get_self_info2?t=0.1';

    protected $referer = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    /**
     * 解析响应数据.
     *
     * @param Response $response
     *
     * @return Profile
     */
    public static function parseResponse(Response $response)
    {
        return GetFriendDetailRequest::parseResponse($response);
    }
}
