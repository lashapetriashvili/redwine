<?php

namespace Redwine\Traits;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Redwine\Facades\Redwine;
use Redwine\Models\Role;

trait RedwineUser
{
    public function role()
    {
        return $this->belongsTo(redwine::modelClass('Role'));
    }

    public function hasPermission($name)
    {
        if (!$this->relationLoaded('role')) {
            $this->load('role');
        }

        if (!$this->role->relationLoaded('permissions')) {
            $this->role->load('permissions');
        }

        return in_array($name, $this->role->permissions->pluck('key')->toArray());
    }
}
