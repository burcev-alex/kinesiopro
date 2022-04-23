<?php

namespace App\Domains\User\Models;

use App\Domains\User\Models\Traits\Relationship\PermissionRelationship;
use App\Domains\User\Models\Traits\Scope\PermissionScope;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * Class Permission.
 */
class Permission extends SpatiePermission
{
    use PermissionRelationship,
        PermissionScope;
}
