<?php

namespace Redwine\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Redwine\Contracts\User as UserContract;
use Redwine\Traits\RedwineUser;

class User extends Authenticatable implements UserContract
{
    use redwineUser;

    protected $guarded = [];
}
