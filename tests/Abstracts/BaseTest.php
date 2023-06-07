<?php

namespace App\Tests\Abstracts;

abstract class BaseTest
{
    const SUCCESS_MESSAGE = 'Test successfull.';
    const ERROR_MESSAGE = 'Test failed.';

    protected function assertEqual($expected, $actual) : void
    {
        try {
            assert($expected == $actual);
            echo self::SUCCESS_MESSAGE . "\n";
        } catch (\Exception $e)
        {
            echo self::ERROR_MESSAGE . "\n";
        }
    }

    protected function assertEmpty(array $list) : void
    {
        try {
            assert(empty($list));
            echo self::SUCCESS_MESSAGE . "\n";
        } catch (\Exception $e)
        {
            echo self::ERROR_MESSAGE . "\n";
        }
    }
}