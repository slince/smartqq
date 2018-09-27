<?php

namespace Slince\SmartQQ\Tests;

use GuzzleHttp\Psr7\Response;
use Slince\SmartQQ\Credential;
use Slince\SmartQQ\CredentialResolver;

class CredentialResolverTest extends TestCase
{
    public function testResolve()
    {
        $resolver = $this->getMockBuilder(CredentialResolver::class)
            ->disableOriginalConstructor()
            ->setMethods(['sendRequest', 'getCookies'])
            ->getMock();

        $forQrImageResponse = $this->createResponseFromFixture('qrcode.png');
        $verifyStatusResponse = $this->createResponseFromFixture('verify_status_certified.txt');
        $forPtWebQQResponse = new Response(200);
        $forVfWebQQResponse = $this->createResponseFromFixture('get_vfwebqq.txt');
        $forUinAndPSessionResponse = $this->createResponseFromFixture('get_uin_psession.txt');
        $getOnlineStatusResponse = $this->createResponseFromFixture('get_friends_online_status.txt');
        $cookies = Credential::fromArray($this->readFixtureFileJson('credential.json'))->getCookies();

        $resolver->expects($this->any())
            ->method('sendRequest')
            ->will($this->onConsecutiveCalls(
                $forQrImageResponse,
                $verifyStatusResponse,
                $forPtWebQQResponse,
                $forVfWebQQResponse,
                $forUinAndPSessionResponse,
                $getOnlineStatusResponse
            ));
        $resolver->expects($this->any())
            ->method('getCookies')
            ->willReturn($cookies);

        $resolver->resolve(function($qrcode){
            $this->assertNotEmpty($qrcode);
        });

        $credential = $resolver->wait();
        $this->assertNotEmpty($credential->getUin());
        $this->assertNotEmpty($credential->getPtWebQQ());
        $this->assertNotEmpty($credential->getVfWebQQ());
        $this->assertNotEmpty($credential->getPSessionId());
    }
}