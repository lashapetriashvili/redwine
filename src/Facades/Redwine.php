<?php

namespace Redwine\Facades;

use illuminate\Support\Facades\Facade;

class Redwine extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "Redwine";
    }
}
