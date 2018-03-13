<?php

namespace Redwine\Models;

use Illuminate\Database\Eloquent\Model;
use Redwine\Facades\Redwine;

class Role extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(Redwine::modelClass('User'), 'user_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Redwine::modelClass('Permission'));
    }
}
