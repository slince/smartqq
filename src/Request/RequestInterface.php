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

interface RequestInterface
{
    /**
     * 请求方式，Get.
     *
     * @var string
     */
    const REQUEST_METHOD_GET = 'GET';

    /**
     * 请求方式，Post.
     *
     * @var string
     */
    const REQUEST_METHOD_POST = 'POST';

    /**
     * 获取请求地址
     *
     * @return string
     */
    public function getUri();

    /**
     * 获取referer.
     *
     * @return string
     */
    public function getReferer();

    /**
     * 获取请求方式.
     *
     * @return string
     */
    public function getMethod();

    /**
     * 获取请求参数.
     *
     * @return string
     */
    public function getParameters();

    /**
     * 设置请求参数.
     *
     * @param array $parameters
     */
    public function setParameters(array $parameters);

    /**
     * 设置请求参数.
     *
     * @param $name
     * @param $parameter
     */
    public function setParameter($name, $parameter);

    /**
     * 设置链接中的占位符.
     *
     * @param $tokens
     */
    public function setTokens($tokens);

    /**
     * 设置链接中的指定占位符.
     *
     * @param $name
     * @param $token
     */
    public function setToken($name, $token);
}
