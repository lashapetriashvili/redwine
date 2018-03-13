<?php

namespace Redwine\Facades;

use illuminate\Support\Facades\Facade;

class Redwine extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "Redwine";
    }
}
