<?php

namespace Slince\SmartQQ\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Entity\Birthday;
use Slince\SmartQQ\Entity\Profile;

class ProfileTest extends TestCase
{
    public function testSetter()
    {
        $profile = new Profile();

        $this->assertNull($profile->getUin());
        $this->assertNull($profile->getAllow());
        $this->assertNull($profile->getAccount());
        $this->assertNull($profile->getLnick());
        $this->assertNull($profile->getEmail());
        $this->assertNull($profile->getBirthday());
        $this->assertNull($profile->getOccupation());
        $this->assertNull($profile->getPhone());
        $this->assertNull($profile->getCollege());
        $this->assertNull($profile->getConstel());
        $this->assertNull($profile->getBlood());
        $this->assertNull($profile->getHomepage());
        $this->assertNull($profile->getStat());
        $this->assertNull($profile->getVipInfo());
        $this->assertNull($profile->getCountry());
        $this->assertNull($profile->getProvince());
        $this->assertNull($profile->getCity());
        $this->assertNull($profile->getPersonal());
        $this->assertNull($profile->getNick());
        $this->assertNull($profile->getShengXiao());
        $this->assertNull($profile->getGender());
        $this->assertNull($profile->getMobile());

        $profile->setUin(1234567);
        $profile->setAllow(1);
        $profile->setAccount(123456);
        $profile->setEmail('foo@foo.com');
        $profile->setLnick('foo lnick');
        $profile->setBirthday(new Birthday(2017, 03, 28));
        $profile->setOccupation('foo');
        $profile->setPhone('123-12345');
        $profile->setCollege('Foo College');
        $profile->setConstel('foo');
        $profile->setBlood(2);
        $profile->setHomepage('http://foo.com');
        $profile->setStat(20);
        $profile->setVipInfo(6);
        $profile->setCountry('CN');
        $profile->setProvince('Bar');
        $profile->setCity('Baz');
        $profile->setPersonal('foo personal');
        $profile->setNick('foo');
        $profile->setShengXiao(5);
        $profile->setGender('male');
        $profile->setMobile('12345678901');

        $this->assertEquals(1234567, $profile->getUin());
        $this->assertEquals(1, $profile->getAllow());
        $this->assertEquals(123456, $profile->getAccount());
        $this->assertEquals('foo@foo.com', $profile->getEmail());
        $this->assertEquals('foo lnick', $profile->getLnick());
        $this->assertInstanceOf(Birthday::class, $profile->getBirthday());
        $this->assertEquals('foo', $profile->getOccupation());
        $this->assertEquals('123-12345', $profile->getPhone());
        $this->assertEquals('Foo College', $profile->getCollege());
        $this->assertEquals('foo', $profile->getConstel());
        $this->assertEquals(2, $profile->getBlood());
        $this->assertEquals('http://foo.com', $profile->getHomepage());
        $this->assertEquals(20, $profile->getStat());
        $this->assertEquals(6, $profile->getVipInfo());
        $this->assertEquals('CN', $profile->getCountry());
        $this->assertEquals('Bar', $profile->getProvince());
        $this->assertEquals('Baz', $profile->getCity());
        $this->assertEquals('foo personal', $profile->getPersonal());
        $this->assertEquals('foo', $profile->getNick());
        $this->assertEquals(5, $profile->getShengXiao());
        $this->assertEquals('male', $profile->getGender());
        $this->assertEquals('12345678901', $profile->getMobile());
    }
}