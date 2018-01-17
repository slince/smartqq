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

class Profile extends User
{
    /**
     * @var int
     */
    protected $allow;

    /**
     * QQ号.
     *
     * @var int
     */
    protected $account;

    /**
     * 邮箱.
     *
     * @var string
     */
    protected $email;

    /**
     * 个性签名.
     *
     * @var string
     */
    protected $lnick;

    /**
     * 生日.
     *
     * @var Birthday
     */
    protected $birthday;

    /**
     * 未知.
     *
     * @var string
     */
    protected $occupation;

    /**
     * 电话.
     *
     * @var string
     */
    protected $phone;

    /**
     * 学院.
     *
     * @var string
     */
    protected $college;

    /**
     * 未知.
     *
     * @var int
     */
    protected $constel;

    /**
     * @var int
     */
    protected $blood;

    /**
     * 主页.
     *
     * @var string
     */
    protected $homepage;

    /**
     * 未知.
     *
     * @var int
     */
    protected $stat;

    /**
     * vip_info.
     *
     * @var int
     */
    protected $vipInfo;

    /**
     * 国家.
     *
     * @var string
     */
    protected $country;

    /**
     * 省
     *
     * @var string
     */
    protected $province;

    /**
     * 城市
     *
     * @var string
     */
    protected $city;

    /**
     * 简介.
     *
     * @var string
     */
    protected $personal;

    /**
     * @var string
     */
    protected $nick;

    /**
     * 生肖.
     *
     * @var int
     */
    protected $shengXiao;

    /**
     * female|male.
     *
     * @var string
     */
    protected $gender;

    /**
     * 手机号.
     *
     * @var string
     */
    protected $mobile;

    /**
     * @return int
     */
    public function getAllow()
    {
        return $this->allow;
    }

    /**
     * @param int $allow
     */
    public function setAllow($allow)
    {
        $this->allow = $allow;
    }

    /**
     * @return int
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param int $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getLnick()
    {
        return $this->lnick;
    }

    /**
     * @param string $lnick
     */
    public function setLnick($lnick)
    {
        $this->lnick = $lnick;
    }

    /**
     * @param Birthday $birthday
     */
    public function setBirthday(Birthday $birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return Birthday
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param string $occupation
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
    }

    /**
     * @return string
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $college
     */
    public function setCollege($college)
    {
        $this->college = $college;
    }

    /**
     * @return string
     */
    public function getCollege()
    {
        return $this->college;
    }

    /**
     * @param int $constel
     */
    public function setConstel($constel)
    {
        $this->constel = $constel;
    }

    /**
     * @return int
     */
    public function getConstel()
    {
        return $this->constel;
    }

    /**
     * @param int $blood
     */
    public function setBlood($blood)
    {
        $this->blood = $blood;
    }

    /**
     * @return int
     */
    public function getBlood()
    {
        return $this->blood;
    }

    /**
     * @param string $homepage
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;
    }

    /**
     * @return string
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @param int $stat
     */
    public function setStat($stat)
    {
        $this->stat = $stat;
    }

    /**
     * @return int
     */
    public function getStat()
    {
        return $this->stat;
    }

    /**
     * @param int $vipInfo
     */
    public function setVipInfo($vipInfo)
    {
        $this->vipInfo = $vipInfo;
    }

    /**
     * @return int
     */
    public function getVipInfo()
    {
        return $this->vipInfo;
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
    public function getCountry()
    {
        return $this->country;
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
    public function getProvince()
    {
        return $this->province;
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
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $personal
     */
    public function setPersonal($personal)
    {
        $this->personal = $personal;
    }

    /**
     * @return string
     */
    public function getPersonal()
    {
        return $this->personal;
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
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * @param int $shengXiao
     */
    public function setShengXiao($shengXiao)
    {
        $this->shengXiao = $shengXiao;
    }

    /**
     * @return int
     */
    public function getShengXiao()
    {
        return $this->shengXiao;
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
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }
}
