<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use OussamaMadjmaa\SofizPay\SofizPayServiceProvider;

abstract class TestCase extends BaseTestCase
{
    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            SofizPayServiceProvider::class,
        ];
    }
}
