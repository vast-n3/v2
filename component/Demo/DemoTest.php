<?php

namespace Neoan3\Component\Demo;

use PHPUnit\Framework\TestCase;

class DemoTest extends TestCase
{
    public function testInit()
    {
        $st = new DemoController();
        $this->expectOutputRegex('/^<!doctype html>/');
        $st->init();
    }
    public function testAuthorization()
    {
        $st = new DemoController();
        $r = $st->getDemo();
        var_dump($r);
    }
}
