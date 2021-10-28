<?php

namespace Hillus\SinTicketingClient\Tests;

use Hillus\SinTicketingClient\Facade;
use Hillus\SinTicketingClient\ServiceProvider;
use Illuminate\Support\Facades\View;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();

        // View::addLocation(__DIR__.'/views');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageAliases($app)
    {
        return [
            'SinTicketingClient' => Facade::class,
        ];
    }
}