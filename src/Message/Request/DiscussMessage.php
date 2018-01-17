<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ\Message\Request;

use Slince\SmartQQ\Entity\Discuss;

class DiscussMessage extends Message
{
    /**
     * @var Discuss
     */
    protected $discuss;

    public function __construct(Discuss $discuss, $content)
    {
        $this->discuss = $discuss;
        parent::__construct($content);
    }

    /**
     * @param Discuss $discuss
     */
    public function setDiscuss($discuss)
    {
        $this->discuss = $discuss;
    }

    /**
     * @return Discuss
     */
    public function getDiscuss()
    {
        return $this->discuss;
    }
}
