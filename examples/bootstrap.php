<?php
/**
 * 案例演示.
 */
use Slince\SmartQQ\Credential;

include __DIR__.'/../vendor/autoload.php';

date_default_timezone_set('Prc');

//二维码图片
define('LOGIN_QR_IMAGE', getcwd().'/smartqq-login-qr.png');

//登录凭证信息保存
define('CREDENTIAL_JSON', getcwd().'/credential.json');

/**
 * 打印结果到屏幕.
 *
 * @param $data
 */
function printPrettyScreen($data)
{
//    printR($data);
    @file_put_contents(getcwd().'/result.log', print_r($data, true)."\r\n", FILE_APPEND);
}

/**
 * 有效输出.
 *
 * @param $data
 */
function printR($data)
{
    //windows中文cmd使用的是gbk编码故需要转换
    print_r($data);
//    echo mb_convert_encoding(print_r($data, true), 'gbk', 'utf-8');
}

/**
 * 获取登录凭证
 *
 * @return Credential
 */
function getCredential()
{
    @$credentialParameters = json_decode(file_get_contents(CREDENTIAL_JSON), true);
    if (!$credentialParameters) {
        exit('Please execute login first');
    }

    return Credential::fromArray($credentialParameters);
}

/**
 * 保存登录凭证
 *
 * @param Credential $credential
 */
function saveCredential(Credential $credential)
{
    @file_put_contents(CREDENTIAL_JSON, json_encode($credential->toArray()));
}