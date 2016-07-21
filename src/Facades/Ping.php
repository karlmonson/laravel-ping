<?php

namespace Karlmonson\Ping\Facades;

use Illuminate\Support\Facades\Facade;

class Ping extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ping';
    }
}