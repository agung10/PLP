<?php

namespace App\Repositories\RoleManagement;

use App\Repositories\BaseRepository;
use App\Models\RoleManagement\UserRole;

class UserRoleRepository extends BaseRepository
{
    public function __construct(UserRole $userRole)
    {
        $this->model = $userRole;
    }
}