<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ\Entity;

class GroupMember extends User
{
    /**
     * flag，作用不明.
     *
     * @var int
     */
    protected $flag;

    /**
     * 昵称.
     *
     * @var string
     */
    protected $nick;

    /**
     * 省
     *
     * @var string
     */
    protected $province;

    /**
     * 性别.
     *
     * @var string
     */
    protected $gender;

    /**
     * 国家.
     *
     * @var string
     */
    protected $country;

    /**
     * 城市
     *
     * @var string
     */
    protected $city;

    /**
     * 群名片.
     *
     * @var string
     */
    protected $card;

    /**
     * 是否是vip.
     *
     * @var string
     */
    protected $isVip;

    /**
     * vip等级.
     *
     * @var int
     */
    protected $vipLevel;

    /**
     * @return string
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * @param string $nick
     */
    public function setNick($nick)
    {
        $this->nick = $nick;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param string $card
     */
    public function setCard($card)
    {
        $this->card = $card;
    }

    /**
     * @return string
     */
    public function isVip()
    {
        return $this->isVip;
    }

    /**
     * @param string $isVip
     */
    public function setIsVip($isVip)
    {
        $this->isVip = $isVip;
    }

    /**
     * @return int
     */
    public function getVipLevel()
    {
        return $this->vipLevel;
    }

    /**
     * @param int $vipLevel
     */
    public function setVipLevel($vipLevel)
    {
        $this->vipLevel = $vipLevel;
    }

    /**
     * @param int $flag
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

    /**
     * @return int
     */
    public function getFlag()
    {
        return $this->flag;
    }
}
