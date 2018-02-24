<?php

namespace Slince\SmartQQ\Tests;

class FooEntity
{
    protected $name;

    /**
     * @param mixed $name
     */
    public function setName(
        $name
    ) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}