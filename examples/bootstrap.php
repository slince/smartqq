<?php
/**
 * 案例演示
 */
include __DIR__ . '/../vendor/autoload.php';

use Slince\SmartQQ\Credential;
date_default_timezone_set('Prc');

//二维码图片
define('LOGIN_QR_IMAGE', getcwd() . '/smartqq-login-qr.png');

define('CREDENTIAL_JSON', getcwd() . '/credential.json');

/**
 * 打印结果到屏幕
 * @param $data
 */
function printPrettyScreen($data)
{
    print_r($data);
    @file_put_contents(getcwd() . '/result.log', print_r($data, true) . "\r\n", FILE_APPEND);
}

/**
 * @return Credential
 */
function getCredential()
{
    $credentialParameters = json_decode(file_get_contents(CREDENTIAL_JSON), true);
    if (!$credentialParameters) {
        exit("Please execute login first");
    }
    return Credential::create($credentialParameters);
}

/**
 * 保存登录凭证
 * @param Credential $credential
 */
function saveCredential(Credential $credential)
{
    @file_put_contents(CREDENTIAL_JSON, json_encode($credential->toArray()));
}
