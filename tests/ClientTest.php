<?php

namespace Slince\SmartQQ\Tests;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Slince\SmartQQ\Client;
use Slince\SmartQQ\Credential;
use Slince\SmartQQ\Entity\Discuss;
use Slince\SmartQQ\Entity\Friend;
use Slince\SmartQQ\Entity\Group;
use Slince\SmartQQ\Exception\Code103ResponseException;
use Slince\SmartQQ\Exception\InvalidArgumentException;
use Slince\SmartQQ\Exception\ResponseException;
use Slince\SmartQQ\Message\Response\DiscussMessage;
use Slince\SmartQQ\Message\Response\FriendMessage;
use Slince\SmartQQ\Message\Response\GroupMessage;

class ClientTest extends TestCase
{
    public function setUp()
    {
        @unlink(static::getQrImagePath());
    }

    /**
     * 创建mock.
     *
     * @param $requestResponse
     *
     * @return Client
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
        $getOnlineStatusResponse = $this->createResponseFromFixture('get_friends_online_status.txt');
        $cookies = Credential::fromArray($this->readFixtureFileJson('credential.json'))->getCookies();
        $client->expects($this->any())
            ->method('sendRequest')
            ->will($this->onConsecutiveCalls(
                $forQrImageResponse,
                $verifyStatusResponse,
                $forPtWebQQResponse,
                $forVfWebQQResponse,
                $forUinAndPSessionResponse,
                $getOnlineStatusResponse
            ));
        $client->expects($this->any())
            ->method('getCookies')
            ->willReturn($cookies);

        $credential = $client->login(static::getQrImagePath());
        $this->assertEquals($credential, $client->getCredential());
        $this->assertInstanceOf(Credential::class, $client->getCredential());
        $this->assertNotEmpty($credential->getUin());
        $this->assertNotEmpty($credential->getPtWebQQ());
        $this->assertNotEmpty($credential->getVfWebQQ());
        $this->assertNotEmpty($credential->getPSessionId());
    }

    public function testGetCredential()
    {
        $client = new Client();
        $this->expectException(InvalidArgumentException::class);
        $client->getCredential();
    }

    public function testCredential()
    {
        //test construct credential
        $credential = Credential::fromArray($this->readFixtureFileJson('credential.json'));
        $client = new Client($credential);
        $this->assertTrue($credential === $client->getCredential());

        //test set credential
        $credential2 = Credential::fromArray($this->readFixtureFileJson('credential.json'));
        $client->setCredential($credential2);
        $this->assertFalse($credential === $client->getCredential());
        $this->assertTrue($credential2 === $client->getCredential());

        //test credential cookies
        $this->assertTrue($client->getCookies() === $credential2->getCookies());
    }

    public function testHttpClient()
    {
        //test default client
        $client = new Client();
        $this->assertNotEmpty($client->getHttpClient());

        //test set client
        $httpClient = new \GuzzleHttp\Client([
            'verify' => true, //默认不开启校验ssl证书
        ]);
        $client->setHttpClient($httpClient);
        $this->assertTrue($httpClient === $client->getHttpClient());

        //test construct httpclient
        $httpClient2 = new \GuzzleHttp\Client([
            'verify' => true, //默认不开启校验ssl证书
            'proxy' => '127.0.0.1:8888',
        ]);
        $client2 = new Client(null, $httpClient2);
        $this->assertTrue($httpClient2 === $client2->getHttpClient());
    }

    public function testGetGroups()
    {
        $groups = $this->createClientMock('get_groups.txt')->getGroups();
        $this->assertCount(2, $groups);

        $group = $groups->first();
        $this->assertNotEmpty($group->getName());
        $this->assertNotEmpty($group->getFlag());
        $this->assertNotEmpty($group->getId());
        $this->assertNotEmpty($group->getCode());
        $this->assertNotEmpty($group->getMarkName());

        return $group;
    }

    /**
     * @depends testGetGroups
     *
     * @param Group $group
     */
    public function testGetGroupDetail(Group $group)
    {
        $detail = $this->createClientMock('get_group_detail.txt')->getGroupDetail($group);

        $this->assertNotEmpty($detail->getGid());
        $this->assertNotEmpty($detail->getName());
        $this->assertNotEmpty($detail->getCode());
        $this->assertNotEmpty($detail->getOwner());
        $this->assertNotEmpty($detail->getLevel());
        $this->assertNotEmpty($detail->getCreateTime());
        $this->assertNotEmpty($detail->getFlag());
        $this->assertNotEmpty($detail->getMemo());
        $this->assertNotEmpty($detail->getMembers());
        $this->assertCount(1, $detail->getMembers());

        //会员
        $member = $detail->getMembers()->first();
        $this->assertNotEmpty($member->getFlag());
        $this->assertNotEmpty($member->getNick());
        $this->assertNotEmpty($member->getProvince());
        $this->assertNotEmpty($member->getGender());
        $this->assertNotEmpty($member->getCountry());
        $this->assertNotEmpty($member->getCity());
        $this->assertNotEmpty($member->getCard());
        $this->assertNotEmpty($member->isVip());
        $this->assertNotEmpty($member->getVipLevel());
    }

    public function testGetDiscusses()
    {
        $discusses = $this->createClientMock('get_discusses.txt')->getDiscusses();
        $this->assertCount(2, $discusses);

        $discuss = $discusses->first();
        $this->assertNotEmpty($discuss->getId());
        $this->assertNotEmpty($discuss->getName());

        return $discuss;
    }

    /**
     * @depends testGetDiscusses
     *
     * @param $discuss
     */
    public function testGetDiscussDetail(Discuss $discuss)
    {
        $detail = $this->createClientMock('get_discuss_detail.txt')->getDiscussDetail($discuss);

        $this->assertNotEmpty($detail->getDid());
        $this->assertNotEmpty($detail->getName());
        $this->assertNotEmpty($detail->getMembers());
        $this->assertCount(1, $detail->getMembers());

        //会员
        $member = $detail->getMembers()->first();
        $this->assertNotEmpty($member->getNick());
        $this->assertNotEmpty($member->getRuin());
        $this->assertNotEmpty($member->getStatus());
        $this->assertNotEmpty($member->getClientType());
    }

    public function testGetFriends()
    {
        $friends = $this->createClientMock('get_friends.txt')->getFriends();
        $this->assertCount(1, $friends);
        $friend = $friends->first();

        $this->assertNotEmpty($friend->getFlag());
        $this->assertNotEmpty($friend->getFace());
        $this->assertNotEmpty($friend->getNick());
//        $this->assertNotEmpty($friend->getQq());
        $this->assertNotEmpty($friend->isVip());
        $this->assertNotEmpty($friend->getVipLevel());
        $this->assertNotEmpty($friend->getCategory());
        $this->assertNotEmpty($friend->getCategory()->getName()); //分类
        $this->assertNotEmpty($friend->getMarkName());

        return $friend;
    }

    /**
     * @depends testGetFriends
     *
     * @param Friend $friend
     */
    public function testGetFriendDetail(Friend $friend)
    {
        $profile = $this->createClientMock('get_friend_detail.txt')->getFriendDetail($friend);
        $this->assertNotEmpty($profile->getUin());
        $this->assertNotEmpty($profile->getEmail());
        $this->assertNotEmpty($profile->getAllow());

        $this->assertNotEmpty($profile->getBirthday());
        $this->assertNotEmpty($profile->getOccupation());
        $this->assertNotEmpty($profile->getPhone());
        $this->assertNotEmpty($profile->getCollege());
        $this->assertNotEmpty($profile->getConstel());
        $this->assertNotEmpty($profile->getBlood());
        $this->assertNotEmpty($profile->getHomepage());
        $this->assertNotEmpty($profile->getStat());
        $this->assertNotEmpty($profile->getVipInfo());
        $this->assertNotEmpty($profile->getCountry());
        $this->assertNotEmpty($profile->getProvince());
        $this->assertNotEmpty($profile->getCity());
        $this->assertNotEmpty($profile->getPersonal());
        $this->assertNotEmpty($profile->getNick());
        $this->assertNotEmpty($profile->getShengXiao());
        $this->assertNotEmpty($profile->getGender());
        $this->assertNotEmpty($profile->getMobile());
    }

    /**
     * @depends testGetFriends
     *
     * @param Friend $friend
     */
    public function testGetFriendQQ(Friend $friend)
    {
        $qq = $this->createClientMock('get_friend_qq.txt')->getFriendQQ($friend);
        $this->assertNotEmpty($qq);
        $this->assertNotEmpty($friend->getQq());
    }

    /**
     * @depends testGetFriends
     *
     * @param Friend $friend
     */
    public function testGetFriendLnick(Friend $friend)
    {
        $lnick = $this->createClientMock('get_friend_lnick.txt')->getFriendLnick($friend);
        $this->assertNotEmpty($lnick);
    }

    public function testGetFriendOnlineStatus()
    {
        $onlineStatus = $this->createClientMock('get_friends_online_status.txt')->getFriendsOnlineStatus();
        $this->assertCount(1, $onlineStatus);
        $onlineStatus = $onlineStatus->first();

        $this->assertNotEmpty($onlineStatus->getStatus());
        $this->assertNotEmpty($onlineStatus->getUin());
        $this->assertNotEmpty($onlineStatus->getClientType());
    }

    public function testGetRecentList()
    {
        $recentList = $this->createClientMock('get_recent_list.txt')->getRecentList();
        $this->assertCount(3, $recentList);

        $recent = $recentList->first();
        $this->assertNotEmpty($recent->getType());
        $this->assertNotEmpty($recent->getUin());
    }

    public function testGetCurrentUser()
    {
        $profile = $this->createClientMock('get_current_user.txt')->getCurrentUserInfo();
        $this->assertNotEmpty($profile->getUin());
        $this->assertNotEmpty($profile->getEmail());
        $this->assertNotEmpty($profile->getAccount());
        $this->assertNotEmpty($profile->getLnick());
        $this->assertNotEmpty($profile->getAllow());

        $this->assertNotEmpty($profile->getBirthday());
        $this->assertNotEmpty($profile->getOccupation());
        $this->assertNotEmpty($profile->getPhone());
        $this->assertNotEmpty($profile->getCollege());
        $this->assertNotEmpty($profile->getConstel());
        $this->assertNotEmpty($profile->getBlood());
        $this->assertNotEmpty($profile->getHomepage());
        $this->assertNotEmpty($profile->getStat());
        $this->assertNotEmpty($profile->getVipInfo());
        $this->assertNotEmpty($profile->getCountry());
        $this->assertNotEmpty($profile->getProvince());
        $this->assertNotEmpty($profile->getCity());
        $this->assertNotEmpty($profile->getPersonal());
        $this->assertNotEmpty($profile->getNick());
        $this->assertNotEmpty($profile->getShengXiao());
        $this->assertNotEmpty($profile->getGender());
        $this->assertNotEmpty($profile->getMobile());
    }

    public function testPollMessages()
    {
        $messages = $this->createClientMock('poll_messages.txt')->pollMessages();
        $this->assertCount(3, $messages);
        //friend message
        $this->assertInstanceOf(FriendMessage::class, $messages[0]);
        $this->assertNotEmpty($messages[0]->getToUin());
        $this->assertNotEmpty($messages[0]->getContent()->getContent());

        //group message
        $this->assertInstanceOf(GroupMessage::class, $messages[1]);
        $this->assertNotEmpty($messages[1]->getToUin());
        $this->assertNotEmpty($messages[1]->getFromUin());
        $this->assertNotEmpty($messages[1]->getGroupCode());
        $this->assertNotEmpty($messages[1]->getSendUin());

        //discuss message
        $this->assertInstanceOf(DiscussMessage::class, $messages[2]);
        $this->assertNotEmpty($messages[2]->getToUin());
        $this->assertNotEmpty($messages[2]->getFromUin());
        $this->assertNotEmpty($messages[2]->getDiscussId());
        $this->assertNotEmpty($messages[2]->getSendUin());
    }

    public function test103CodeResponse()
    {
        $this->expectException(Code103ResponseException::class);
        $this->createClientMock('103_response.txt')->pollMessages();
    }

    public function testResponseException()
    {
        $this->expectException(ResponseException::class);
        $this->createClientMock('response_exception.txt')->pollMessages();
    }

    /**
     * @depends testGetFriends
     *
     * @param $friend
     */
    public function testSendMessage($friend)
    {
        $group = $this->createClientMock('get_groups.txt')->getGroups()->first();
        $discuss = $this->createClientMock('get_discusses.txt')->getDiscusses()->first();
        $client = $this->createClientMock('send_message.txt');
        $this->assertTrue($client->sendMessage(new \Slince\SmartQQ\Message\Request\FriendMessage($friend, '你好')));
        $this->assertTrue($client->sendMessage(new \Slince\SmartQQ\Message\Request\GroupMessage($group, '你好')));
        $this->assertTrue($client->sendMessage(new \Slince\SmartQQ\Message\Request\DiscussMessage($discuss, '你好')));
    }

    /**
     * @param $fixtureFilename
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

    protected function createResponseFromFixture($filename, $statusCode = 200, $headers = [])
    {
        return new Response($statusCode, $headers, $this->readFixtureFile($filename));
    }

    protected function readFixtureFile($filename)
    {
        $content = file_get_contents(__DIR__."/Fixtures/{$filename}");
        if (false === $content) {
            throw new \Exception(sprintf('Fixture [%s] does not exists', $filename));
        }

        return $content;
    }

    protected function readFixtureFileJson($filename)
    {
        $rawContent = $this->readFixtureFile($filename);

        return \GuzzleHttp\json_decode($rawContent, true);
    }

    protected static function getQrImagePath()
    {
        return __DIR__.'/login.png';
    }

    public function tearDown()
    {
        @unlink(static::getQrImagePath());
    }
}