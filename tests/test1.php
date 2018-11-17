<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class test1 extends TestCase
{
    public function testSucceed()
    {
        self::assertTrue(true);
    }

    public function testFail()
    {
        self::assertFalse(true);
    }
}