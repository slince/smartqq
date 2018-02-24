<?php

namespace Slince\SmartQQ\Tests;

use GuzzleHttp\Cookie\CookieJar;
use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Credential;

class CredentialTest extends TestCase
{
    public function testGetter()
    {
        $credential = new Credential('foo', 'bar', 'baz', 1234, 604800, new CookieJar());

        $this->assertEquals('foo', $credential->getPtWebQQ());
        $this->assertEquals('bar', $credential->getVfWebQQ());
        $this->assertEquals('baz', $credential->getPSessionId());
        $this->assertEquals(1234, $credential->getUin());
        $this->assertEquals(604800, $credential->getClientId());
        $this->assertInstanceOf(CookieJar::class, $credential->getCookies());
    }

    public function testSetter()
    {
        $credential = new Credential('foo', 'bar', 'baz', 1234, 604800, new CookieJar());

        $credential->setPtWebQQ('foo1');
        $credential->setVfWebQQ('bar1');
        $credential->setPSessionId('baz1');
        $credential->setUin(12345);
        $credential->setClientId(6048001);

        $this->assertEquals('foo1', $credential->getPtWebQQ());
        $this->assertEquals('bar1', $credential->getVfWebQQ());
        $this->assertEquals('baz1', $credential->getPSessionId());
        $this->assertEquals(12345, $credential->getUin());
        $this->assertEquals(6048001, $credential->getClientId());
    }

    public function testToArray()
    {
        $credential = new Credential('foo', 'bar', 'baz', 1234, 604800, new CookieJar());
        $this->assertEquals([
            'ptWebQQ' => 'foo',
            'vfWebQQ' => 'bar',
            'pSessionId' => 'baz',
            'uin' => 1234,
            'clientId' => 604800,
            'cookies' => [],
        ], $credential->toArray());
    }

    public function testFromArray()
    {
        $parameters = [
            'ptWebQQ' => 'foo',
            'vfWebQQ' => 'bar',
            'pSessionId' => 'baz',
            'uin' => 1234,
            'clientId' => 604800,
            'cookies' => [],
        ];
        $credential = Credential::fromArray($parameters);
        $this->assertEquals('foo', $credential->getPtWebQQ());
        $this->assertEquals('bar', $credential->getVfWebQQ());
        $this->assertEquals('baz', $credential->getPSessionId());
        $this->assertEquals(1234, $credential->getUin());
        $this->assertEquals(604800, $credential->getClientId());
    }
}