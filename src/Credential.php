<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ;

use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;

class Credential
{
    /**
     * 鉴权参数ptwebqq，存储在cookie中.
     *
     * @var string
     */
    protected $ptWebQQ;

    /**
     * 鉴权参数vfwebqq.
     *
     * @var string
     */
    protected $vfWebQQ;

    /**
     * 鉴权参数pSessionId.
     *
     * @var string
     */
    protected $pSessionId;

    /**
     * 客户端id.
     *
     * @var int
     */
    protected $clientId;

    /**
     * 当前登录的用户编号（o+QQ号）.
     *
     * @var string
     */
    protected $uin;

    /**
     * cookie信息,由于client发起请求需要使用cookie信息故cookie也需要一同处理.
     *
     * @var CookieJar
     */
    protected $cookies;

    public function __construct($ptWebQQ, $vfWebQQ, $pSessionId, $uin, $clientId, CookieJar $cookies)
    {
        $this->ptWebQQ = $ptWebQQ;
        $this->vfWebQQ = $vfWebQQ;
        $this->pSessionId = $pSessionId;
        $this->uin = $uin;
        $this->clientId = $clientId;
        $this->cookies = $cookies;
    }

    /**
     * @return string
     */
    public function getPtWebQQ()
    {
        return $this->ptWebQQ;
    }

    /**
     * @param string $ptWebQQ
     */
    public function setPtWebQQ($ptWebQQ)
    {
        $this->ptWebQQ = $ptWebQQ;
    }

    /**
     * @return string
     */
    public function getVfWebQQ()
    {
        return $this->vfWebQQ;
    }

    /**
     * @param string $vfWebQQ
     */
    public function setVfWebQQ($vfWebQQ)
    {
        $this->vfWebQQ = $vfWebQQ;
    }

    /**
     * @return string
     */
    public function getPSessionId()
    {
        return $this->pSessionId;
    }

    /**
     * @return CookieJar
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @param CookieJar $cookies
     */
    public function setCookies($cookies)
    {
        $this->cookies = $cookies;
    }

    /**
     * @param string $pSessionId
     */
    public function setPSessionId($pSessionId)
    {
        $this->pSessionId = $pSessionId;
    }

    /**
     * @return int
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param int $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getUin()
    {
        return $this->uin;
    }

    /**
     * @param string $uin
     */
    public function setUin($uin)
    {
        $this->uin = $uin;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'ptWebQQ' => $this->ptWebQQ,
            'vfWebQQ' => $this->vfWebQQ,
            'pSessionId' => $this->pSessionId,
            'uin' => $this->uin,
            'clientId' => $this->clientId,
            'cookies' => $this->cookies->toArray(),
        ];
    }

    /**
     * Create from a array data.
     *
     * @param $data
     *
     * @return static
     */
    public static function fromArray(array $data)
    {
        $cookieJar = null;
        if (isset($data['cookies'])) {
            $cookieJar = new CookieJar();
            foreach ($data['cookies'] as $cookie) {
                $cookieJar->setCookie(new SetCookie($cookie));
            }
        }

        return new static($data['ptWebQQ'], $data['vfWebQQ'],
            $data['pSessionId'], $data['uin'], $data['clientId'],
            $cookieJar
        );
    }
}
