<?php

/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ;


class MessageHandler
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var callable
     */
    protected $onMessageHandler;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function 
}