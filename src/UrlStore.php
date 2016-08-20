<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ;

class UrlStore
{
    /**
     * 二维码图片地址
     * @var string
     */
    const GET_QR_CODE = 'https://ssl.ptlogin2.qq.com/ptqrshow?appid=501004106&e=0&l=M&s=5&d=72&v=4&t=0.1';

    /**
     * 验证二维码图片状态
     * @var string
     */
    const VERIFY_QR_CODE = 'https://ssl.ptlogin2.qq.com/ptqrlogin?webqq_type=10&remember_uin=1&login2qq=1&aid=501004106 &u1=http%3A%2F%2Fw.qq.com%2Fproxy.html%3Flogin2qq%3D1%26webqq_type%3D10 &ptredirect=0&ptlang=2052&daid=164&from_ui=1&pttype=1&dumy=&fp=loginerroralert &action=0-0-157510&mibao_css=m_webqq&t=1&g=1&js_type=0&js_ver=10143&login_sig=&pt_randsalt=0';

    /**
     * 验证二维码图片状态referer
     * @var string
     */
    const VERIFY_QR_CODE_REFERER = 'https://ui.ptlogin2.qq.com/cgi-bin/login?daid=164&target=self&style=16&mibao_css=m_webqq&appid=501004106&enable_qlogin=0&no_verifyimg=1 &s_url=http%3A%2F%2Fw.qq.com%2Fproxy.html&f_url=loginerroralert &strong_login=1&login_state=10&t=20131024001';

    /**
     * 获取ptwebqq参数referer
     * @var string
     */
    const GET_PTWEBQQ_REFERER = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    /**
     * 获取vfwebqq参数
     * @var string
     */
    const GET_VFWEBQQ = 'http://s.web2.qq.com/api/getvfwebqq?ptwebqq=#{ptwebqq}&clientid=53999199&psessionid=&t=0.1';

    /**
     * 获取vfwebqq参数referer
     * @var string
     */
    const GET_VFWEBQQ_REFERER = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    /**
     * 获取uin和psessionid
     * @var string
     */
    const GET_UINANDPSESSIONID = 'http://d1.web2.qq.com/channel/login2';

    /**
     * 获取uin和psessionid的REFERER
     * @var string
     */
    const GET_UINANDPSESSIONID_REFERER = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    /**
     * 获取好友列表
     * @var string
     */
    const GET_USER_FRIENDS = 'http://s.web2.qq.com/api/get_user_friends2';

    /**
     * 获取好友列表的REFERER
     * @var string
     */
    const GET_USER_FRIENDS_REFERER = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    /**
     * 获取好友在线状态
     * @var string
     */
    const GET_FRIENDS_ONLINE_STATUS = 'http://d1.web2.qq.com/channel/get_online_buddies2?vfwebqq=#{vfwebqq}&clientid=53999199&psessionid=#{psessionid}&t=0.1';

    /**
     * 获取好友在线状态referer
     * @var string
     */
    const GET_FRIENDS_ONLINE_STATUS_REFERER = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    /**
     * 获取好友qq号
     * @var string
     */
    const GET_QQ = 'http://s.web2.qq.com/api/get_friend_uin2?tuid=#{uin}&type=1&vfwebqq=#{vfwebqq}&t=0.1';

    /**
     * 获取好友qq号referer
     * @var string
     */
    const GET_QQ_REFERER = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    /**
     * 获取好友详细信息
     * @var string
     */
    const GET_FRIEND_DETAIL = 'http://s.web2.qq.com/api/get_friend_info2?tuin=#{uin}&vfwebqq=#{vfwebqq}&clientid=53999199&psessionid=#{psessionid}&t=0.1';

    /**
     * 获取好友详细信息referer
     * @var string
     */
    const GET_FRIEND_DETAIL_REFERER = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';
}