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

class VerifyQrCodeRequest extends Request
{
    /**
     * 二维码状态，未失效.
     *
     * @var int
     */
    const STATUS_UNEXPIRED = 1;

    /**
     * 二维码状态，已失效.
     *
     * @var int
     */
    const STATUS_EXPIRED = 2;

    /**
     * 二维码状态，认证中.
     *
     * @var int
     */
    const STATUS_ACCREDITATION = 3;

    /**
     * 二维码状态，认证成功
     *
     * @var int
     */
    const STATUS_CERTIFICATION = 4;

    protected $uri = 'https://ssl.ptlogin2.qq.com/ptqrlogin?ptqrtoken={ptqrtoken}&webqq_type=10&remember_uin=1&login2qq=1&aid=501004106&u1=http%3A%2F%2Fw.qq.com%2Fproxy.html%3Flogin2qq%3D1%26webqq_type%3D10&ptredirect=0&ptlang=2052&daid=164&from_ui=1&pttype=1&dumy=&fp=loginerroralert&action=0-0-4303&mibao_css=m_webqq&t=undefined&g=1&js_type=0&js_ver=10203&login_sig=&pt_randsalt=0';

    protected $referer = 'https://ui.ptlogin2.qq.com/cgi-bin/login?daid=164&target=self&style=16&mibao_css=m_webqq&appid=501004106&enable_qlogin=0&no_verifyimg=1 &s_url=http%3A%2F%2Fw.qq.com%2Fproxy.html&f_url=loginerroralert &strong_login=1&login_state=10&t=20131024001';

    public function __construct($ptQrToken)
    {
        $this->setToken('ptqrtoken', $ptQrToken);
    }
}
