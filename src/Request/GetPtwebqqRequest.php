<?php
/**
 * Slince SmartQQ Library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\SmartQQ\Request;

use Slince\SmartQQ\UrlStore;

class GetPtwebqqRequest extends AbstractRequest
{
    protected $referer = UrlStore::GET_PTWEBQQ_REFERER;
}