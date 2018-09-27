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
use Slince\SmartQQ\Exception\RuntimeException;

class CredentialResolver
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var CookieJar
     */
    protected $cookies;

    /**
     * 获取ptwebqq的地址
     *
     * @var string
     */
    protected $certificationUrl;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * 获取授权凭据.
     *
     * @param callable $qrCallback
     * @return $this
     */
    public function resolve($qrCallback)
    {
        // 重置cookie
        $this->cookies = new CookieJar();
        //获取二维码资源
        $response = $this->sendRequest(new Request\GetQrCodeRequest());
        $qrCallback((string)$response->getBody());

        return $this;
    }

    /**
     * 等待授权验证.
     *
     * @return Credential
     */
    public function wait()
    {
        //查找"qrsig"参数
        $qrSign = $this->findQRSign();
        //计算ptqrtoken
        $ptQrToken = Utils::hash33($qrSign);

        //验证状态
        while (true) {
            //查看二维码状态
            $status = $this->getQrCodeStatus($ptQrToken);

            // 认证成功
            if (Request\VerifyQrCodeRequest::STATUS_CERTIFICATION === $status) {
                //授权成功跳出状态检查
                break;
            } elseif (Request\VerifyQrCodeRequest::STATUS_EXPIRED == $status) {
                //查找"qrsig"参数
                $qrSign = $this->findQRSign();
                //计算ptqrtoken
                $ptQrToken = Utils::hash33($qrSign);
            }
            //暂停1秒
            usleep(1000000);
        }

        $ptWebQQ = $this->getPtWebQQ();
        $vfWebQQ = $this->getVfWebQQ($ptWebQQ);
        list($uin, $pSessionId) = $this->getUinAndPSessionId($ptWebQQ);

        $credential = new Credential(
            $ptWebQQ,
            $vfWebQQ,
            $pSessionId,
            $uin,
            Client::$clientId, //smartqq保留字段，固定值
            $this->cookies
        );

        return $credential;
    }

    /**
     * 从cookie中查找 "qrsig" 参数
     *
     * @return string
     */
    protected function findQRSign()
    {
        foreach ($this->getCookies() as $cookie) {
            if (0 === strcasecmp($cookie->getName(), 'qrsig')) {
                return $cookie->getValue();
            }
        }
        throw new RuntimeException('Can not find parameter [qrsig]');
    }

    /**
     * 验证二维码状态
     *
     * @param int $ptQrToken qr token
     *
     * @return int
     */
    protected function getQrCodeStatus($ptQrToken)
    {
        $request = new Request\VerifyQrCodeRequest($ptQrToken);
        $response = $this->sendRequest($request);
        if (false !== strpos($response->getBody(), '未失效')) {
            $status = Request\VerifyQrCodeRequest::STATUS_UNEXPIRED;
        } elseif (false !== strpos($response->getBody(), '已失效')) {
            $status = Request\VerifyQrCodeRequest::STATUS_EXPIRED;
        } elseif (false !== strpos($response->getBody(), '认证中')) {
            $status = Request\VerifyQrCodeRequest::STATUS_ACCREDITATION;
        } else {
            $status = Request\VerifyQrCodeRequest::STATUS_CERTIFICATION;
            //找出认证url
            if (preg_match("#'(http.+)'#U", strval($response->getBody()), $matches)) {
                $this->certificationUrl = trim($matches[1]);
            } else {
                throw new RuntimeException('Can not find certification url');
            }
        }

        return $status;
    }

    /**
     * 获取ptwebqq的参数值
     *
     * @return string
     */
    protected function getPtWebQQ()
    {
        $request = new Request\GetPtWebQQRequest();
        $request->setUri($this->certificationUrl);
        $this->sendRequest($request);
        foreach ($this->getCookies() as $cookie) {
            if (0 === strcasecmp($cookie->getName(), 'ptwebqq')) {
                return $cookie->getValue();
            }
        }
        throw new RuntimeException('Can not find parameter [ptwebqq]');
    }

    /**
     * @param string $ptWebQQ
     *
     * @return string
     */
    protected function getVfWebQQ($ptWebQQ)
    {
        $request = new Request\GetVfWebQQRequest($ptWebQQ);
        $response = $this->sendRequest($request);

        return Request\GetVfWebQQRequest::parseResponse($response);
    }

    /**
     * 获取pessionid和uin.
     *
     * @param string $ptWebQQ
     *
     * @return array
     */
    protected function getUinAndPSessionId($ptWebQQ)
    {
        $request = new Request\GetUinAndPsessionidRequest([
            'ptwebqq' => $ptWebQQ,
            'clientid' => Client::$clientId,
            'psessionid' => '',
            'status' => 'online',
        ]);
        $response = $this->sendRequest($request);

        return Request\GetUinAndPsessionidRequest::parseResponse($response);
    }

    protected function sendRequest(Request\RequestInterface $request)
    {
        return $this->client->sendRequest($request, [
            'cookies' => $this->cookies //使用当前cookies
        ]);
    }

    protected function getCookies()
    {
        return $this->cookies;
    }
}