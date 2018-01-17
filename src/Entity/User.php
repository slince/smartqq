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

class User
{
    /**
     * 用户编号.
     *
     * @var int
     */
    protected $uin;

    /**
     * @return int
     */
    public function getUin()
    {
        return $this->uin;
    }

    /**
     * @param int $uin
     */
    public function setUin($uin)
    {
        $this->uin = $uin;
    }
}
