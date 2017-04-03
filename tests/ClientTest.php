<?php
namespace Slince\SmartQQ\Tests;

use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\Response;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Client;
use Slince\SmartQQ\Credential;

class ClientTest extends TestCase
{
    static $loginImageFile = __DIR__ . '/login.png';

    /**
     * 创建mock
     * @param $requestResponse
     * @return  Client
     */
    protected function getClientMock($requestResponse)
    {
        return $this->getMockBuilder(Client::class)->getMock()
            ->method('sendRequest')
            ->willReturn($requestResponse);
    }

    public function testLogin()
    {
        $client = $this->getMockBuilder(Client::class)
            ->setMethods(['sendRequest', 'getCookies'])
            ->getMock();

        $forQrImageResponse = $this->createResponseFromFixture('qrcode.png');
        $verifyStatusResponse = $this->createResponseFromFixture('verify_status_certified.txt');
        $forPtWebQQResponse = new Response(200);
        $forVfWebQQResponse = $this->createResponseFromFixture('get_vfwebqq.txt');
        $forUinAndPSessionResponse = $this->createResponseFromFixture('get_uin_psession.txt');


        $cookies = Credential::fromArray($this->readFixtureFileJson('credential.json'))->getCookies();
        $client->expects($this->any())
            ->method('sendRequest')
            ->will($this->onConsecutiveCalls(
                $forQrImageResponse,
                $verifyStatusResponse,
                $forPtWebQQResponse,
                $forVfWebQQResponse,
                $forUinAndPSessionResponse
            ));
        $client->expects($this->any())
            ->method('getCookies')
            ->willReturn($cookies);

        $credential = $client->login(static::$loginImageFile);
        $this->assertEquals($credential, $client->getCredential());
        $this->assertInstanceOf(Credential::class, $client->getCredential());
        $this->assertNotEmpty($credential->getUin());
        $this->assertNotEmpty($credential->getPtWebQQ());
        $this->assertNotEmpty($credential->getVfWebQQ());
        $this->assertNotEmpty($credential->getPSessionId());
    }

    protected function createResponseFromFixture($filename, $statusCode = 200, $headers = [])
    {
        return new Response($statusCode, $headers, $this->readFixtureFile($filename));
    }

    protected function readFixtureFile($filename)
    {
        $content = file_get_contents(__DIR__ . "/Fixtures/{$filename}");
        if ($content === false) {
            throw new \Exception(sprintf("Fixture [%s] does not exists", $filename));
        }
        return $content;
    }

    protected function readFixtureFileJson($filename)
    {
        $rawContent = $this->readFixtureFile($filename);
        return \GuzzleHttp\json_decode($rawContent, true);
    }
}