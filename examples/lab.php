<?php

$content = "ptuiCB('0','0','http://ptlogin4.web2.qq.com/check_sig?pttype=1&uin=1045541707&service=ptqrlogin&nodirect=0&ptsigx=87a726cbd567318207cd970e3d2d76c26bd7765db2e307aed68e1f1f0b8e3e4b405857854f89ae80e1a28365ed1962269d8d4d84b5368d9316e525a76723378f&s_url=http%3A%2F%2Fw.qq.com%2Fproxy.html%3Flogin2qq%3D1%26webqq_type%3D10&f_url=https%3A%2F%2Fmail.qq.com%2Fcgi-bin%2Flogin%3Flc%3Dzh_CN%26vm%3Dptf%26ptlang%3D2052%26Fun%3Dclientread%26mailid%3DZC1924-sDbO3G0YELdjdloCj13aQ73%26httptype%3D0%26ADUIN%3D749187462%26ADSESSION%3D1490318244%26ADTAG%3DCLIENT.QQ.5497_.0%26ADPUBNO%3D26661&ptlang=2052&ptredirect=100&aid=501004106&daid=164&j_later=0&low_login_hour=0&regmaster=0&pt_login_type=3&pt_aid=0&pt_aaid=16&pt_light=0&pt_3rd_aid=0','0','鐧诲綍鎴愬姛锛?, '绉嬮€?);";
$result = preg_match("#'(http.+)'#U", $content, $matches);

var_dump($result);
print_r($matches);

