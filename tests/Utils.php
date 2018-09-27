<?php

namespace Slince\SmartQQ\Tests;

use GuzzleHttp\Psr7\Response;

class Utils
{
    public static function createResponseFromFixture($filename, $statusCode = 200, $headers = [])
    {
        return new Response($statusCode, $headers, static::readFixtureFile($filename));
    }

    public static function readFixtureFileJson($filename)
    {
        $rawContent = static::readFixtureFile($filename);

        return \GuzzleHttp\json_decode($rawContent, true);
    }

    public static function readFixtureFile($filename)
    {
        $content = file_get_contents(__DIR__."/Fixtures/{$filename}");
        if (false === $content) {
            throw new \Exception(sprintf('Fixture [%s] does not exists', $filename));
        }
        return $content;
    }
}