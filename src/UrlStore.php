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

/**
 * Class UrlStore.
 *
 * @deprecated
 */
final class UrlStore
{
    /**
     * 二维码图片地址
     *
     * @var string
     */
    const GET_QR_CODE = 'https://ssl.ptlogin2.qq.com/ptqrshow?appid=501004106&e=0&l=M&s=5&d=72&v=4&t=0.1';

    /**
     * 验证二维码图片状态
     *
     * @var string
     */
    const VERIFY_QR_CODE = 'https://ssl.ptlogin2.qq.com/ptqrlogin?ptqrtoken={ptqrtoken}&webqq_type=10&remember_uin=1&login2qq=1&aid=501004106&u1=http%3A%2F%2Fw.qq.com%2Fproxy.html%3Flogin2qq%3D1%26webqq_type%3D10&ptredirect=0&ptlang=2052&daid=164&from_ui=1&pttype=1&dumy=&fp=loginerroralert&action=0-0-307845&mibao_css=m_webqq&t=undefined&g=1&js_type=0&js_ver=10203&login_sig=&pt_randsalt=0';

    /**
     * 验证二维码图片状态referer.
     *
     * @var string
     */
    const VERIFY_QR_CODE_REFERER = 'https://ui.ptlogin2.qq.com/cgi-bin/login?daid=164&target=self&style=16&mibao_css=m_webqq&appid=501004106&enable_qlogin=0&no_verifyimg=1 &s_url=http%3A%2F%2Fw.qq.com%2Fproxy.html&f_url=loginerroralert &strong_login=1&login_state=10&t=20131024001';

    /**
     * 获取ptwebqq参数referer.
     *
     * @var string
     */
    const GET_PTWEBQQ_REFERER = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    /**
     * 获取vfwebqq参数.
     *
     * @var string
     */
    const GET_VFWEBQQ = 'http://s.web2.qq.com/api/getvfwebqq?ptwebqq={ptwebqq}&clientid=53999199&psessionid=&t=0.1';

    /**
     * 获取vfwebqq参数referer.
     *
     * @var string
     */
    const GET_VFWEBQQ_REFERER = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    /**
     * 获取uin和psessionid.
     *
     * @var string
     */
    const GET_UINANDPSESSIONID = 'http://d1.web2.qq.com/channel/login2';

    /**
     * 获取uin和psessionid的REFERER.
     *
     * @var string
     */
    const GET_UINANDPSESSIONID_REFERER = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    /**
     * 获取好友列表.
     *
     * @var string
     */
    const GET_USER_FRIENDS = 'http://s.web2.qq.com/api/get_user_friends2';

    /**
     * 获取好友列表的REFERER.
     *
     * @var string
     */
    const GET_USER_FRIENDS_REFERER = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    /**
     * 获取好友在线状态
     *
     * @var string
     */
    const GET_FRIENDS_ONLINE_STATUS = 'http://d1.web2.qq.com/channel/get_online_buddies2?vfwebqq={vfwebqq}&clientid=53999199&psessionid={psessionid}&t=0.1';

    /**
     * 获取好友在线状态referer.
     *
     * @var string
     */
    const GET_FRIENDS_ONLINE_STATUS_REFERER = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    /**
     * 获取好友qq号.
     *
     * @var string
     */
    const GET_QQ = 'http://s.web2.qq.com/api/get_friend_uin2?tuid={uin}&type=1&vfwebqq={vfwebqq}&t=0.1';

    /**
     * 获取好友qq号referer.
     *
     * @var string
     */
    const GET_QQ_REFERER = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    /**
     * 获取好友详细信息.
     *
     * @var string
     */
    const GET_FRIEND_DETAIL = 'http://s.web2.qq.com/api/get_friend_info2?tuin={uin}&vfwebqq={vfwebqq}&clientid=53999199&psessionid={psessionid}&t=0.1';

    /**
     * 获取好友详细信息referer.
     *
     * @var string
     */
    const GET_FRIEND_DETAIL_REFERER = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    /**
     * 获取群.
     *
     * @var string
     */
    const GET_GROUPS = 'http://s.web2.qq.com/api/get_group_name_list_mask2';

    /**
     * 获取群referer.
     *
     * @var string
     */
    const GET_GROUPS_REFERER = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    /**
     * 获取群详细信息.
     *
     * @var string
     */
    const GET_GROUP_DETAIL = 'http://s.web2.qq.com/api/get_group_info_ext2?gcode={group_code}&vfwebqq={vfwebqq}&t=0.1';

    /**
     * 获取群详细信息referer.
     *
     * @var string
     */
    const GET_GROUP_DETAIL_REFERER = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    /**
     * 获取讨论组.
     *
     * @var string
     */
    const GET_DISCUSES = 'http://s.web2.qq.com/api/get_discus_list?clientid=53999199&psessionid={psessionid}&vfwebqq={vfwebqq}&t=0.1';

    /**
     * 获取讨论组referer.
     *
     * @var string
     */
    const GET_DISCUSES_REFERER = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    /**
     * 获取讨论组详细信息.
     *
     * @var string
     */
    const GET_DISCUS_DETAIL = 'http://d1.web2.qq.com/channel/get_discu_info?did={discuss_id}&psessionid={psessionid}&vfwebqq={vfwebqq}&clientid=53999199&t=0.1';

    /**
     * 获取讨论组详细信息referer.
     *
     * @var string
     */
    const GET_DISCUS_DETAIL_REFERER = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    /**
     * 获取最近会话详情.
     *
     * @var string
     */
    const GET_RECENT_LIST = 'http://d1.web2.qq.com/channel/get_recent_list2';

    /**
     * 获取当前登录用户信息.
     *
     * @var string
     */
    const GET_LOGIN_INFO = 'http://s.web2.qq.com/api/get_self_info2&t=0.1';

    /**
     * 获取当前登录用户信息referer.
     *
     * @var string
     */
    const GET_LOGIN_INFO_REFERER = 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1';

    /**
     * 轮询消息.
     *
     * @var string
     */
    const POLL_MESSAGES = 'http://d1.web2.qq.com/channel/poll2';

    /**
     * 轮询消息referer.
     *
     * @var string
     */
    const POLL_MESSAGES_REFERER = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    /**
     * 发送消息给好友.
     *
     * @var string
     */
    const SEND_MESSAGE_TO_FRIEND = 'http://d1.web2.qq.com/channel/send_buddy_msg2';

    /**
     * 发送消息给好友referer.
     *
     * @var string
     */
    const SEND_MESSAGE_TO_FRIEND_REFERER = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    /**
     * 发送群消息referer.
     *
     * @var string
     */
    const SEND_MESSAGE_TO_GROUP = 'http://d1.web2.qq.com/channel/send_qun_msg2';

    /**
     * 发送群消息referer.
     *
     * @var string
     */
    const SEND_MESSAGE_TO_GROUP_REFERER = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';

    /**
     * 发送讨论组消息.
     *
     * @var string
     */
    const SEND_MESSAGE_TO_DISCUS = 'http://d1.web2.qq.com/channel/send_discu_msg2';

    /**
     * 发送讨论组消息referer.
     *
     * @var string
     */
    const SEND_MESSAGE_TO_DISCUS_REFERER = 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2';
}
