<?php
/**
 * SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Message\Request;

use Slince\SmartQQ\Entity\Discuss;
use Slince\SmartQQ\Message\Content;

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
