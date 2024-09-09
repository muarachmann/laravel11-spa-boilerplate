<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laratrust\Models\Permission as LaratrustPermission;

class Permission extends LaratrustPermission
{
    public $guarded = [];

    public function users(): MorphToMany
    {
        return $this->morphedByMany(
            config('laratrust.user_models')['users'],
            'user',
            config('laratrust.tables.permission_user'),
            config('laratrust.foreign_keys.permission'),
            config('laratrust.foreign_keys.user')
        );
    }
}
