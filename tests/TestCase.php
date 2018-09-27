<?php
namespace Slince\SmartQQ\Tests;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Slince\SmartQQ\Client;
use Slince\SmartQQ\Credential;

class TestCase extends BaseTestCase
{
    public function createResponseFromFixture($filename, $statusCode = 200, $headers = [])
    {
        return new Response($statusCode, $headers, $this->readFixtureFile($filename));
    }

    public function readFixtureFileJson($filename)
    {
        $rawContent = $this->readFixtureFile($filename);

        return \GuzzleHttp\json_decode($rawContent, true);
    }

    public function readFixtureFile($filename)
    {
        $content = file_get_contents(__DIR__."/Fixtures/{$filename}");
        if (false === $content) {
            throw new \Exception(sprintf('Fixture [%s] does not exists', $filename));
        }
        return $content;
    }

    /**
     * @param string $fixtureFilename
     *
     * @return Client
     */
    protected function createClientMock($fixtureFilename)
    {
        $credential = Credential::fromArray($this->readFixtureFileJson('credential.json'));
        $response = $this->createResponseFromFixture($fixtureFilename);

        $client = $this->getMockBuilder(Client::class)
            ->setMethods(['sendRequest', 'getCredential'])
            ->getMock();

        $client->expects($this->any())
            ->method('sendRequest')
            ->willReturn($response);

        $client->expects($this->any())
            ->method('getCredential')
            ->willReturn($credential);

        return $client;
    }
}