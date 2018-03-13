<?php

namespace Redwine\Contracts;

interface User
{
    public function role();

    public function hasPermission($name);
}
