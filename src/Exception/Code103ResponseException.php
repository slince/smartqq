<?php
/*
 * This file is part of the slince/smartqq package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\SmartQQ\Exception;

class Code103ResponseException extends ResponseException
{
    public function __construct($response = null)
    {
        $message = 'Please visit http://w.qq.com, confirm that you can send and receive messages and then exit';
        parent::__construct(103, $response, $message);
    }
}
